<?php 

if(isset($_SESSION['Nivo']))
{
    require_once("konekcija.php");
    
    if(isset($_POST['dugme']) && $_POST['dugme']=="PretraziSat")    
    {
        if(isset($_POST['BrojKampera']) && isset($_POST['DatumPocetka']) && isset($_POST['DatumZavrsetka']))
        {
            $TipMesta = "Satorsko";
            $Rentira = $_POST['Rentira'];
            $BrojKampera = $_POST['BrojKampera'];
            $DatumPocetka = $_POST['DatumPocetka'];
            $DatumZavrsetka = $_POST['DatumZavrsetka'];
            
            $upit = "SELECT * FROM smestaj 
                      WHERE SatorPrikolica = 0 
                      AND Obrisan = 0 
                      AND Rentira = ? 
                      AND Kapacitet >= ? 
                      AND RedniBrojMesta NOT IN (
                          SELECT RedniBrojMesta 
                          FROM rezervacija 
                          WHERE (StatusRezervacije = 'Cekanje' OR StatusRezervacije = 'Aktivna') 
                          AND ((DatumPocetka BETWEEN ? AND ?) OR (DatumZavrsetka BETWEEN ? AND ?))
                      )";

            $stmt = $mysqli->prepare($upit);
            $stmt->bind_param("iissss", $Rentira, $BrojKampera, $DatumPocetka, $DatumZavrsetka, $DatumPocetka, $DatumZavrsetka);
            $stmt->execute();
            $rez = $stmt->get_result(); 
            ?> 
            <h2>Dostupna satorska mesta za unete parametre</h2>
            <br>
            <form action="kreiranjeRezervacije.php" method="post">
                
                <?php 
                if($rez->num_rows > 0){
                    while($red=$rez->fetch_assoc())
                    { ?>
                        <fieldset>
                            <legend><h4><strong><?php echo $TipMesta;?></strong></h4></legend>  
                            <div class="form-group">
                                <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                                <div class="col-md-10">
                                    <input readonly class="form-control text-box single-line" id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="<?php echo $red['RedniBrojMesta'] ?>">
                                </div>
                            </div>

                            <input type="hidden" id="BrojKampera" name="BrojKampera" value="<?php echo $BrojKampera ?>">
                            <input type="hidden" id="DatumPocetka" name="DatumPocetka" value="<?php echo $DatumPocetka ?>">
                            <input type="hidden" id="DatumZavrsetka" name="DatumZavrsetka" value="<?php echo $DatumZavrsetka ?>">
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="Tip">Tip</label>
                                <div class="col-md-10">
                                    <input readonly class="form-control text-box single-line" id="Tip" name="Tip" type="text" value="<?php echo $red['Tip'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="Opis">Opis</label>
                                <div class="col-md-10">
                                    <textarea readonly class="form-control textarea" id="Opis" name="Opis"><?php echo $red['Opis'] ?></textarea>
                                </div>
                            </div>   
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="Kapacitet">Kapacitet</label>
                                <div class="col-md-10">
                                    <input readonly class="form-control text-box single-line" id="Kapacitet" name="Kapacitet" type="text" value="<?php echo $red['Kapacitet'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica</label>
                                <div class="col-md-10">
                                    <input readonly class="form-control text-box single-line" id="SatorPrikolica" name="SatorPrikolica" type="text" value="<?php echo $red['SatorPrikolica'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="Rentira">Rentira</label>
                                <div class="col-md-10">
                                    <select readonly disabled class="form-control select" id="Rentira" name="Rentira">
                                        <?php if($red['Rentira'] == 0) { ?>
                                           <option selected value="0">Nije potreban sator</option>
                                           <option value="1">Potreban sator</option>    
                                           <?php 
                                       } else if($red['Rentira'] == 1) { ?>
                                          <option value="0">Nije potreban sator</option>
                                          <option selected value="1">Potreban sator</option>    
                                          <?php
                                      } ?>  
                                  </select>
                              </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-2" for="Cena">Cena</label>
                            <div class="col-md-10">
                                <input readonly class="form-control text-box single-line" id="Cena" name="Cena" type="number" value="<?php echo $red['Cena'] ?>">
                            </div>
                        </div>
                        <br><br><br>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <input name="dugme" id="dugme" value="Rezervisi" type="submit" class="btn btn-success">
                            </div>
                        </div>
                        
                    </fieldset>   
                <?php } 
            }
            else {  ?>
                <br><br><br>
                <h3>Ne postoji odgovarajuci smestaj za unete parametre! Probajte druge datume ili promenite neki drugi uslov. Hvala!</h3><br>
                <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;"></a><br>
                </strong>                
                <?php    
            }  ?>
        </div>
    </form>
    <br>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Odustani - povratak na listu rezervacija</a>
        </div>
    </div>
    
    <?php 
    }    
    else if(isset($_POST['dugme']) && $_POST['dugme']=="PretraziPrik")
    {  
        if(isset($_POST['BrojKampera']) && isset($_POST['DatumPocetka']) && isset($_POST['DatumZavrsetka']))
        {
            $TipMesta = "Za prikolicu";
            $Rentira = $_POST['Rentira'];
            $BrojKampera = $_POST['BrojKampera'];
            $StrujaPrikljucak = $_POST['StrujaPrikljucak'];
            $VodaPrikljucak = $_POST['VodaPrikljucak'];
            $DatumPocetka = $_POST['DatumPocetka'];
            $DatumZavrsetka = $_POST['DatumZavrsetka'];
            
            $upit2 = "SELECT * FROM smestaj 
                       WHERE SatorPrikolica = 1 
                       AND Obrisan = 0 
                       AND Rentira = ? 
                       AND StrujaPrikljucak = ? 
                       AND VodaPrikljucak = ? 
                       AND RedniBrojMesta NOT IN (
                           SELECT RedniBrojMesta 
                           FROM rezervacija 
                           WHERE (StatusRezervacije = 'Cekanje' OR StatusRezervacije = 'Aktivna') 
                           AND ((DatumPocetka BETWEEN ? AND ?) OR (DatumZavrsetka BETWEEN ? AND ?))
                       )"; 

            $stmt2 = $mysqli->prepare($upit2);
            $stmt2->bind_param("iiissss", $Rentira, $StrujaPrikljucak, $VodaPrikljucak, $DatumPocetka, $DatumZavrsetka, $DatumPocetka, $DatumZavrsetka);
            $stmt2->execute();
            $rez2 = $stmt2->get_result(); 
            ?> 
            <h2>Dostupna mesta za prikolicu za unete parametre</h2>
            <br>
            <form action="kreiranjeRezervacije.php" method="post">
                
                <?php 
                if($rez2->num_rows > 0){
                    while($red2=$rez2->fetch_assoc())
                    { ?>
                        <fieldset>
                            <legend><h4><strong><?php echo $TipMesta;?></strong></h4></legend>  
                            <div class="form-group">
                                <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                                <div class="col-md-10">
                                    <input readonly class="form-control text-box single-line" id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="<?php echo $red2['RedniBrojMesta'] ?>">
                                </div>
                            </div>

                            <input type="hidden" id="BrojKampera" name="BrojKampera" value="<?php echo $BrojKampera ?>">
                            <input type="hidden" id="DatumPocetka" name="DatumPocetka" value="<?php echo $DatumPocetka ?>">
                            <input type="hidden" id="DatumZavrsetka" name="DatumZavrsetka" value="<?php echo $DatumZavrsetka ?>">
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="Tip">Tip</label>
                                <div class="col-md-10">
                                    <input readonly class="form-control text-box single-line" id="Tip" name="Tip" type="text" value="<?php echo $red2['Tip'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="Opis">Opis</label>
                                <div class="col-md-10">
                                    <textarea readonly class="form-control textarea" id="Opis" name="Opis"><?php echo $red2['Opis'] ?></textarea>
                                </div>
                            </div>   
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="Kapacitet">Kapacitet</label>
                                <div class="col-md-10">
                                    <input readonly class="form-control text-box single-line" id="Kapacitet" name="Kapacitet" type="text" value="<?php echo $red2['Kapacitet'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica</label>
                                <div class="col-md-10">
                                    <input readonly class="form-control text-box single-line" id="SatorPrikolica" name="SatorPrikolica" type="text" value="<?php echo $red2['SatorPrikolica'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="Rentira">Rentira</label>
                                <div class="col-md-10">
                                    <select readonly disabled class="form-control select" id="Rentira" name="Rentira">
                                        <?php if($red2['Rentira'] == 0) { ?>
                                           <option selected value="0">Nije potrebna struja</option>
                                           <option value="1">Potreban struja</option>   
                                           <?php 
                                       } else if($red2['Rentira'] == 1) { ?>
                                          <option value="0">Nije potrebna struja</option>
                                          <option selected value="1">Potreban struja</option>   
                                          <?php
                                      } ?>  
                                  </select>
                              </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-2" for="Cena">Cena</label>
                            <div class="col-md-10">
                                <input readonly class="form-control text-box single-line" id="Cena" name="Cena" type="number" value="<?php echo $red2['Cena'] ?>">
                            </div>
                        </div>
                        <br><br><br>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <input name="dugme" id="dugme" value="Rezervisi" type="submit" class="btn btn-success">
                            </div>
                        </div>
                        
                    </fieldset>   
                <?php } 
            }
            else {  ?>
                <br><br><br>
                <h3>Ne postoji odgovarajuci smestaj za unete parametre! Probajte druge datume ili promenite neki drugi uslov. Hvala!</h3><br>
                <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;"></a><br>
                </strong>                
                <?php    
            }  ?>
        </div>
    </form>
    <br>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Odustani - povratak na listu rezervacija</a>
        </div>
    </div>
    
    <?php 
    }
} else { ?>  

            <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br>
            <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br>
            </strong>
            <?php 
        } ?>