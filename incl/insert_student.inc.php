<?php
header("Content-Type: text/html; charset=utf-8");
$host = "localhost";
$user = "root";
$pass = "";
$database = "etf_rfid";

if (!$db=mysql_connect($host, $user, $pass)) {
	die ("<b>Spajanje na mysql server je bilo neuspješno</b>");
}
if (!mysql_select_db($database, $db)) {
	die ("<b>Greška pri odabiru baze</b>");
}
else {
	mysql_query("set names utf8",$db);
}

$sql = "
INSERT INTO student (prezime, ime, br_indeks) VALUES
('Abazović', 'Božo', '169'),
('Abazović', 'Milica', '524'),
('Abazović', 'Bojana', '149'),
('Adžić', 'Aleksandar', '550'),
('Adžić', 'Damjan', '1181'),
('Adžić', 'Andrijana', '468'),
('Adžić', 'Saša', '276'),
('Ajkalo', 'Srđan', '293'),
('Alaković', 'Slobodan', '64'),
('Aleksić', 'Nemanja', '878'),
('Aleksić', 'Jelena', '719'),
('Andan', 'Lea', '1141'),
('Andrić', 'Jovo', '879'),
('Andrić', 'Dejan', '937'),
('Andrić', 'Vladan', '360'),
('Andrić', 'Ranko', '717'),
('Antić', 'Vladimir', '229'),
('Antić', 'Andrej', '765'),
('Arnautović', 'Dejan', '292'),
('Arnautović', 'Mehmed', '516'),
('Ateljević', 'Milenko', '306'),
('Avdalović', 'Miroslav', '386'),
('Avdalović', 'Radoš', '1235'),
('Avdalović', 'Miljan', '163'),
('Avlijaš', 'Goran', '27'),
('Avlijaš', 'Aleksandar', '394'),
('Avlijaš', 'Slađan', '326'),
('Aškraba', 'Ranka', '1011'),
('Aškraba', 'Zoran', '590'),
('Babić', 'Vojislav', '501'),
('Babić', 'Nataša', '6'),
('Badnjar', 'Biljana', '987'),
('Bajić', 'Nada', '166'),
('Bakoč', 'Srđan', '796'),
('Banduka', 'Zoran', '439'),
('Banduka', 'Dejan', '4'),
('Banjanin', 'Mladen', '842'),
('Banović', 'Rajko', '1284'),
('Batinić', 'Jovan', '583'),
('Batinić', 'Svjetlana', '185'),
('Batinić', 'Vladan', '785'),
('Batković', 'Sanja', '578'),
('Batković', 'Goran', '811'),
('Bašić', 'Miodrag', '437'),
('Berat', 'Petar', '1308'),
('Beribaka', 'Milan', '991'),
('Beribaka', 'Ognjen', '896'),
('Bezjak', 'Mia', '1096'),
('Bijeljac', 'Dragan', '364'),
('Biljić', 'Milija', '742'),
('Bjelica', 'Milan', '599'),
('Bjelica', 'Nikola', '480'),
('Bjelica', 'Ognjen', '767'),
('Bjelica', 'Dragan', '86'),
('Bjelica', 'Stefan', '978'),
('Bjelica', 'Igor', '1171'),
('Bjelić', 'Marko', '1078'),
('Bjelobrk', 'Davor', '275'),
('Bjeloglav', 'Dejan', '974'),
('Bjelogrlić', 'Milorad', '349'),
('Blagojević', 'Tanja', '620'),
('Blagojević', 'Ognjen', '218'),
('Blagojević', 'Aleksandar', '1107'),
('Blagojević', 'Drago', '507'),
('Blagovčanin', 'Mladen', '1036'),
('Bodulović', 'Danijel', '3'),
('Bogdanović', 'Dušanka', '54'),
('Bogdanović', 'Dalibor', '83'),
('Bogdanović', 'Dušanka', '107'),
('Bogdanović', 'Duško', '121'),
('Bojanić', 'Bojan', '1131'),
('Bojanić', 'Dragan', '487'),
('Bojović', 'Marinko', '483'),
('Bojović', 'Mirjana', '266'),
('Bojović', 'Stefan', '992'),
('Boljanić', 'Borislav', '1042'),
('Boljanović', 'Vladan', '667'),
('Borković', 'Nikola', '739'),
('Borovčanin', 'Goran', '1190'),
('Borovčanin', 'Dejan', '395'),
('Borovina', 'Ognjen', '518'),
('Borovina', 'Miroslav', '747'),
('Borovnica', 'Mirjana', '946'),
('Botić', 'Bogdan', '660'),
('Bozalo', 'Branka', '1048'),
('Bozalo', 'Stefan', '1219'),
('Bošković', 'Boris', '1240'),
('Bošković', 'Marko', '1102'),
('Bošković', 'Ðorđe', '1110'),
('Bošković', 'Bojan', '1241'),
('Božić', 'Igor', '418'),
('Božić', 'Mile', '354'),
('Božić', 'Branimir', '400'),
('Božić', 'Goran', '28'),
('Božović', 'Mirko', '769'),
('Bratić', 'Miljana', '55'),
('Bratić', 'Bojan', '452'),
('Brđanin', 'Milan', '864'),
('Brčkalo', 'Dejan', '1248'),
('Brezo', 'Radomirka', '484'),
('Brusin', 'Branko', '301'),
('Bucalo', 'Slaviša', '1307'),
('Budalić', 'Miloš', '884'),
('Budinčić', 'Vladimir', '729'),
('Buha', 'Bosiljko', '664'),
('Bujić', 'Slobodan', '180'),
('Bulajić', 'Boris', '131'),
('Bundalo', 'Oliver', '23'),
('Bunijevac', 'Rade', '299'),
('Bunjevački', 'Jovan', '434'),
('Buntić', 'Zdenko', '892'),
('Butulija', 'Srđan', '702'),
('Camović', 'Haris', '1073'),
('Cerovina', 'Dražen', '144'),
('Cerovina', 'Dragoslav', '60'),
('Cerovina', 'Dajana', '902'),
('Cerovina', 'Ranka', '725'),
('Cicović', 'Vladimir', '601'),
('Cicović', 'Ksenija', '700'),
('Cincar', 'Aleksandar', '246'),
('Crnjak', 'Ranka', '671'),
('Crnjak', 'Jelena', '668'),
('Crnovčić', 'Velibor', '519'),
('Cvek', 'Marko', '744'),
('Cvijetinović', 'Aleksandar', '953'),
('Cvijetić', 'Tanja', '964'),
('Cvijetić', 'Snježana', '570'),
('Cvijetić', 'Branislava', '151'),
('Cvijetić', 'Branislav', '19'),
('Cvjetinović', 'Stefan', '1022'),
('Dabić', 'Ognjen', '285'),
('Dačević', 'Boško', '1202'),
('Dajčman', 'Ana', '8'),
('Dajčman', 'Ana', '508'),
('Ðajić', 'Dragan', '76'),
('Ðajić', 'Aleksandar', '153'),
('Damjanac', 'Peđa', '1066'),
('Damjanac', 'Miljan', '791'),
('Damjanac', '®ivko', '938'),
('Damjanović', 'Davor', '141'),
('Damjanović', 'Miljan', '15'),
('Damjanović', 'Miroslav', '433'),
('Damjanović', 'Slaven', '340'),
('Damjanović', 'Mirko', '1012'),
('Davidović', 'Igor', '1030'),
('Davidović', 'Nikola', '385'),
('Delić', 'Zorica', '943'),
('Delić', 'Jelena', '494'),
('Ðerić', 'Milan', '818'),
('Ðerić', 'Slobodanka', '1084'),
('Ðerić', 'Jadranka', '803'),
('Despetović', 'Vladimir', '711'),
('Divčić', 'Velibor', '655'),
('Divčić', 'Miroslav', '586'),
('Divčić', 'Dragan', '150'),
('Divčić', 'Božidar', '279'),
('Divljan', 'Tamara', '30'),
('Divljan', 'Predrag', '318'),
('Divljan', 'Ilija', '1280'),
('Divljan', 'Nikola', '977'),
('Divović', 'Mile', '849'),
('Doder', 'Radenko', '679'),
('Doder', 'Srđan', '207'),
('Dodik', 'Siniša', '208'),
('Ðogić', 'Ðorđe', '888'),
('Ðogo', 'Ðorđe', '538'),
('Ðokanović', 'Zdravko', '116'),
('Ðokanović', 'Aleksandar', '1089'),
('Ðokić', 'Nemanja', '1286'),
('Ðokić', 'Milan', '1037'),
('Ðokić', 'Vladimir', '220'),
('Ðokić', 'Nataša', '979'),
('Domazet', 'Ðorđe', '995'),
('Domazet', 'Borislav', '881'),
('Ðorđić', 'Siniša', '728'),
('Ðorem', 'Branislav', '120'),
('Ðorem', 'Vitomir', '112'),
('Dostanić', 'Mladen', '754'),
('Dragaš', 'Milan', '640'),
('Dragičević', 'Vladimir', '461'),
('Dragović', 'Dimitrije', '1094'),
('Dragović', 'Dimitrije', '136'),
('Drakul', 'Jelena', '143'),
('Drakul', 'Nikola', '265'),
('Drakul', 'Srđan', '1164'),
('Draško', 'Dragan', '804'),
('Drašković', 'Aleksandar', '94'),
('Drašković', 'Srđan', '504'),
('Drekalović', 'Goran', '768'),
('Drinjak', 'Obren', '1160'),
('Drljača', 'Dalibor', '157'),
('Drobnjak', 'Ana', '573'),
('Drobnjak', 'Nikola', '870'),
('Drvendžija', 'Dejan', '1205'),
('Dubajić', 'Nikola', '90'),
('Dubovina', 'Tanja', '787');
";
mysql_query($sql,$db) or die(mysql_error());
echo "Uneseno:" . mysql_affected_rows($db);
?>