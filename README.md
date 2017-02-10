# htmlord

1. Population cap, territoorium.
	Kuni mingi levelini on võimalik osta/teha maad juurde kasutades ressursse nagu lihtsalt upgradena,
	aga siis peab hakkama võitlema maa eest. Mitte päris inimeste vastu, aga lihtsalt territooriumi
	kasvatamine muutub. Võtab aega 1h ja on võimalus, et nurjub.
	Mingi mõte on ka päris inimeste vastu territooriumi kasvatamine, teiste mängijatelt ära võtmine, aga see oleks liiga karm.
2. Overall balance.
	iga upgrade ei anna juurde mitte tervet ühte modi, vaid nt .1 vmidagi.
	arvutused toimuvad phps ja enne databasesse saatmist round().
	paljunemine maksab rohkem ressursse.
3. reputation.
	igal mängijal on reputatioon algselt 100%, sellest sõltub kui palju saab kaubandamisest kulda nt.
	reppi kaotab siis, kui sa ründad kedagi. kui palju sa kaotad sõltub sellest kui palju vastasel on reppi, mida rohkem, seda rohkem sa kaotad.
	kui sa ründad vastast kelle populatsioon on üle poole väiksem kui sinul, siis on repi kaotus kahe- või isegi kolmekordne.
	reppi on võimalik saada heategudest.
4. autoriteet.
	igal mängijal on autoriteet algselt 0%, sellest sõltub kui palju saab paljunemisest inimesi juurde nt.
	autoriteeti kaotab siis kui keegi võidab rünnaku sinu vastu või sa kaotad rünnakul.
	kui sa võidad rünnakul vastast kellel on sinust suurem populatsioon, siis saad rohkem autoriteeti.
5. rivaali süsteem.
	kaks mängijat võivad mõlema nõusolekult hakata üksteise rivaalideks.
	kui sa ründad rivaali, siis sa ei kaota reputatiooni ja saad võites rohkem autoriteeti.
6. hideouts.
	igal mängijal on oma hideout. sinna pandud ressursse ei saa keegi varastada. mahutavus sõltub territori suurusest.
7. kaubandussüsteem.
	eraldi leht, kus saab müüa liigsed ressursid raha vastu ja raha ressursside vastu.
8. blacksmith.
	see on koht, kus mängija saab tellida relvi oma sõdurite jaoks.
	blacksmithile võib ka maksta, et ta leiutaks tõhusamaid relvi ja nii unlockitakse uusi, paremaid relvi.
9. religion.
	tavaline clannisüsteem, mida selles mänguks võiks kutsuda religioonideks. erinevatest religioonidest inimesi saab rünnata, oma religiooni
	ei saa rünnata. oma religiooni kaaslaseid sõjas aidates saad reputatsiooni.
	igal religioonil on oma leht, oma foorum, oma strateegia. nt mõned religioonid on sõjakad ja võtavad vastu inimesi, kes on hea ründes
	ja vastupidi mõned religioonid on kaitsvamad jne.
10. ründaja või kaitsja aitamine.
	kui on käimas rünnak (aega 1h) siis igaüks võib otsustada kas ta tahab selles rünnakus osaleda. see võib sõltuda religioonist.
11. rumours.
	iga mängija võib teise mängija lehele jätta väikese teate, mis oleks väike kirjeldus. nt ta on fcking munn, koguaeg ründab pede
12. teadete süsteem.
	kui mängijat rünnatakse, siis saadetakse talle sellest teade, et ta saaks kaitseks valmistuda. kutsuda sõpru appi või vabastada tööjõudu
	teadete alla võiksid mängijad üksteisele sõnumeid ka nt saata.
