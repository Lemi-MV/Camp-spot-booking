<?php 
if(isset($_SESSION['Nivo']))
{   
    if($_GET['tip'] == "sat")
    {    
?>
    <h1>Provera dostupnosti za satorska mesta</h1><br><bsr>
    <h3>Unesite broj kampera, da li vam je potreban sator i datume boravka</h3><br><br>
	<form action="mesta.php" method="post">
		<div class="container body-content">
    <fieldset>    
        <div class="form-group">
            <label class="control-label col-md-2" for="BrojKampera">Broj kampera</label>
            <div class="col-md-4">
                <input class="form-control text-box single-line" required id="BrojKampera" min="1" name="BrojKampera" type="number" value="">
            </div>
        </div><br><br>

        <div class="form-group">
                <label class="control-label col-md-2" for="Rentira">Iznajmljuje sator</label>
                <div class="col-md-8">
                    <select class="form-control select" data-val="true" required id="Rentira" name="Rentira">
                            <option value="1">Potreban sator</option>
                            <option value="0">Nije potreban sator</option>
                    </select>
                </div>
        </div><br><br>

		<div class="form-group">
            <label class="control-label col-md-2" for="DatumPocetka">Datum početka</label>
            <div class="col-md-6">
                <input class="form-control text-box single-line" min="<?php echo date("Y-m-d");?>" required id="DatumPocetka" name="DatumPocetka" onchange="OnChangeEvent();" type="date" value="">
            </div>
        </div><br><br>

        <div class="form-group">
            <label class="control-label col-md-2" for="DatumZavrsetka">Datum zavrsetka</label>
            <div class="col-md-6">
                <input class="form-control text-box single-line" required id="DatumZavrsetka" min="" name="DatumZavrsetka" type="date" value="">
            </div>
        </div><br><br>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button name="dugme" id="dugme" value="PretraziSat" type="submit" class="btn btn-success">Pretrazi</button>
            </div>
            <div>
                <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Odustani - nazad na listu</a>
            </div>
        </div>
    </fieldset>
		</div>
	</form>
<?php 
        }
    else if($_GET['tip'] == "prik")
        {
    
 ?>
    <h1>Provera dostupnosti</h1><br><br>
    <h3>Unesite da li zelite da iznajmite prikolicu/kamper, koje prikljucke zelite, broj kampera i datume boravka</h3><br><br>
	<form action="mesta.php" method="post">    
		<div class="container body-content">
    <fieldset>        
        <div class="form-group">
                <label class="control-label col-md-4" for="Rentira">Iznajmljuje prikolicu / kamper </label>
                <div class="col-md-8">
                    <select class="form-control select" data-val="true" required id="Rentira" name="Rentira">
                            <option value="1">Potrebna prikolica / kamper</option>
                            <option value="0">Nije potrebna prikolica / kamper</option>
                    </select>
                </div>
            </div><br><br>

            <div class="form-group">
                <label class="control-label col-md-4" for="StrujaPrikljucak">Struja prikljucak </label>
                <div class="col-md-8">
                    <select class="form-control select" data-val="true" required id="StrujaPrikljucak" name="StrujaPrikljucak">
                            <option value="1">Potrebna struja</option>
                            <option value="0">Ne treba struja</option>
                    </select>
                </div>
            </div><br><br>

            <div class="form-group">
                <label class="control-label col-md-4" for="VodaPrikljucak">Voda prikljucak </label>
                <div class="col-md-8">
                    <select class="form-control select" data-val="true" required id="VodaPrikljucak" name="VodaPrikljucak">
                            <option value="1">Potrebna voda</option>
                            <option value="0">Ne treba voda</option>
                    </select>
                </div>
            </div><br><br>

            <div class="form-group">
            <label class="control-label col-md-2" for="BrojKampera">Broj kampera</label>
            <div class="col-md-4">
                <input class="form-control text-box single-line" required id="BrojKampera" min="1" name="BrojKampera" type="number" value="">
            </div>
            </div><br><br>

		<div class="form-group">
            <label class="control-label col-md-2" for="DatumPocetka">Datum početka</label>
            <div class="col-md-6">
                <input class="form-control text-box single-line" min="<?php echo date("Y-m-d");?>" required id="DatumPocetka" name="DatumPocetka" onchange="OnChangeEvent();" type="date" value="">
            </div>
        </div><br><br>

        <div class="form-group">
            <label class="control-label col-md-2" for="DatumZavrsetka">Datum zavrsetka</label>
            <div class="col-md-6">
                <input class="form-control text-box single-line" required id="DatumZavrsetka" min="" name="DatumZavrsetka" type="date" value="">
            </div>
        </div><br><br>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button name="dugme" id="dugme" value="PretraziPrik" type="submit" class="btn btn-success">Pretrazi</button>
            </div>
            <div>
                <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Odustani - nazad na listu</a>
            </div>
        </div>
        </fieldset>
		</div>
	</form>
<?php  }
}else
{ 
    ?>
        <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br>
        <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br></strong>
<?php 
} 
?>

<script>
    function OnChangeEvent() {

        var pocetniDatum = document.getElementById('DatumPocetka').value;
        var datumZavrsetka = document.getElementById('DatumZavrsetka').value;

        document.getElementById("DatumZavrsetka").setAttribute('min', pocetniDatum);
        document.getElementById("DatumZavrsetka").removeAttribute("readonly");

        document.getElementById("DatumZavrsetka").value = pocetniDatum;
    }
</script>