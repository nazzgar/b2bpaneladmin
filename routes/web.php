<?php

use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\ResetPassword;
use App\Settings\ReturnLimits;
use B2BPanel\SharedModels\CustomerUser;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (ReturnLimits $limits) {
    dd($limits->jezykowe_oxford);
    return view('welcome');
});

Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect(route('filament.auth.login'));
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::get('/login', function () {
    return redirect(route('filament.auth.login'));
})->name('login');

Route::get('/seed', function () {
    /* $users_data = [["000190", "papirusnatolin@gmail.com"], ["000833", "ksiegarnia_paulina@o2.pl"], ["000878", "krisdruk@post.pl"], ["001114", "hurtownia.marko@wp.pl"], ["001159", "wiesiakwolek@gmail.com"], ["001244", "ksiegarniaesej@wp.pl"], ["001388", "wsp.siedlce@wp.pl"], ["001398", "marcinzawadzkimarki@gmail.com"], ["001401", "ksiegarniauiwony@op.pl"], ["002071", "j.lewinski62@gmail.com"], ["002080", "maksyma@poczta.onet.pl"], ["005677", "teczowyksiegarnia@gmail.com"], ["006090", "ksiegarniabasia@op.pl"], ["0061631", "sklep.bibliotekarium@gmail.com"], ["0080373", "kontakt@matfel.pl"], ["009190", "ksiegarnia1@op.pl"], ["009942", "rym.p-no@wp.pl"], ["010853", "witold.wietrzynski@gmail.com"], ["013147", "elwo17@wp.pl"], ["013224", "ksiegarniajola@wp.pl"], ["013301", "bozennapajewska@op.pl"], ["013773", "taniaksiazka@op.pl"], ["015324", "best29@wp.pl"], ["015515", "agatazd70@gmail.com"], ["015516", "saskizbigniew@poczta.onet.pl"], ["016217", "ks@podreczniki-beniamina.pl"], ["020384", "ksiegarniaarturszadkowski@vp.pl"], ["027330", "ksiegarniatomaszewska@wp.pl"], ["027587", "evelpro@hot.pl"], ["029995", "papierowyswiat@vp.pl"], ["041954", "dz.handlowy@glosel.pl"], ["053014", "phedukator@o2.pl"], ["055730", "ksiegarnia_bzyk@op.pl"], ["061122", "ksiegarniaelf@gmail.com"], ["070716", "korob@korob.pl"], ["070803", "ksiegarniatj.wolomin@gmail.com"], ["071146", "tomtad0@onet.eu"], ["073748", "bozena.bondarowicz@interia.pl"], ["073796", "vademecumpila@onet.pl"], ["095154", "horyzont21@gmail.com"], ["096351", "lidka68@o2.pl"], ["102181", "worldlink@wp.pl"], ["106242", "pmj.alp@wp.pl"], ["112244", "alicja.fk@vp.pl"], ["112338", "wolumengn@post.pl"], ["112562", "dom.ksiazki@idsl.pl"], ["115227", "marba661@wp.pl"], ["115235", "zbigzat@wp.pl"], ["117462", "ksiegarnia_wolumen@o2.pl"], ["119724", "phu.fajtek@wp.pl"], ["119726", "ideandg@wp.pl"], ["119993", "ksiegsezam@op.pl"], ["120461", "wiedza101@wp.pl"], ["129553", "antykwariat73@o2.pl"], ["129557", "sowazory@wp.pl"], ["131235", "popnaukowa@ksiaznica.pl"], ["136684", "domksiazkikrot@interia.pl"], ["142255", "faktura@czytam.pl"], ["145074", "eger_zamosc@o2.pl"], ["147246", "info@antykwariat-lublin.pl"], ["148776", "ksiegarniaalf@wp.pl"], ["190219", "ksiegarnia.kaliska@o2.pl"], ["213677", "barbara.krakowska@op.pl"], ["230229", "meg7676@wp.pl"], ["242215", "robert-osowicz01@tlen.pl"], ["263858", "tdk.ksiazki@gmail.com"], ["266088", "danuta.konopko@gmail.com"], ["275811", "ksiegarniatetris@wp.pl"], ["279250", "adriankotlarz@vp.pl"], ["295560", "ksiegarniauleszka@wp.pl"], ["296601", "anetaotlowska@wp.pl"], ["304589", "ewa.lawniczak1997@gmail.com"], ["306375", "amigopm@op.pl"], ["308584", "wejherowoksiegarnia@gmail.com"], ["310697", "ksiegarnia.ania@interia.pl"], ["345388", "swit683@gmail.com"], ["357914", "daria.oleszko@gmail.com"], ["359334", "czeslaw.handel@wp.pl"]];
    $users_data2 = [
        ["0001312", "avalonstary@ksiaznica.pl"],
        ["001136", "errata@ksiaznica.pl"],
        ["0014772", "sonet@ksiaznica.pl"],
        ["0014773", "sonetjunior@ksiaznica.pl"],
        ["0014875", "gora@biblioart.pl"],
        ["0014876", "milicz@biblioart.pl"],
        ["0014878", "slupca@biblioart.pl"],
        ["0041188", "hermiona@ksiaznica.pl"],
        ["0062911", "papierniczy.kutno@tlen.pl"],
        ["0080802", "tarnobrzeg@kolibra.pl"],
        ["0080803", "stalowawola@kolibra.pl"],
        ["0084307", "kropka@ksiaznica.pl"],
        ["010596", "lexica@ksiaznica.pl"],
        ["013796", "wena@ksiaznica.pl"],
        ["014135", "abc@ksiaznica.pl"],
        ["025450", "krasickiego@ksiaznica.pl"],
        ["028646", "zamkowa@ksiaznica.pl"],
        ["0477115", "przecinek@ksiaznica.pl"],
        ["0478107", "rodzinna@ksiaznica.pl"],
        // --> tu jest duplikat ["048250", "daria.oleszko@gmail.com"],
        ["073156", "mentor@ksiaznica.pl"],
        ["074493", "czestochowa@szkolna.net.pl"],
        ["074890", "pabianice@szkolna.net.pl"],
        ["074895", "tarnow@szkolna.net.pl"],
        ["075319", "piotrkow@szkolna.net.pl"],
        ["075394", "rybnik@szkolna.net.pl"],
        ["146117", "bajka@ksiaznica.pl"],
        ["146119", "swit@ksiaznica.pl"],
        ["217093", "pegaz@ksiaznica.pl"],
        ["257018", "falenica-ksiegarnia@wp.pl"],
        ["257730", "iwonaszerszen@wp.pl"],
        ["263381", "bielsko-biala@kolibra.pl"],
        ["265658", "chrzanow@kolibra.pl"],
        ["295561", "ksiegarniauleszka3@op.pl"],
        ["303490", "cieszyn@kolibra.pl"],
        ["344525", "gliwice@kolibra.pl"]
    ]; */

    /* $sum_length = count($users_data) + count($users_data2); */

    /* dd($sum_length); */

    /* $users_data = [
        ["0000646", "podsowa@o2.pl"],
        ["0001312", "avalonstary@ksiaznica.pl"],
        ["0001313", "avalonfabryczny@ksiaznica.pl"],
        ["0001682", "mateusz.skarszewy@gmail.com"],
        ["000190", "papirusnatolin@gmail.com"],
        ["000245", "ksiegarniabooks@wp.pl"],
        ["000468", "kamix.sc@gmail.com"],
        ["000729", "ks_orbita@poczta.onet.pl"],
        ["000758", "wiedza@ksiaznica.pl"],
        ["000783", "jobce@gkn.com.pl"],
        ["000833", "ksiegarnia_paulina@o2.pl"],
        ["000878", "krisdruk@post.pl"],
        ["001047", "metis@ksiaznica.pl"],
        ["001114", "hurtownia.marko@wp.pl"],
        ["001122", "ksiegarnia_lichosik@wp.pl"],
        ["001136", "errata@ksiaznica.pl"],
        ["001159", "wiesiakwolek@gmail.com"],
        ["001244", "ksiegarniaesej@wp.pl"],
        ["001289", "gw1704@wp.pl"],
        ["0013114", "slawomir.k@opoczta.pl"],
        ["001388", "wsp.siedlce@wp.pl"],
        ["001398", "marcinzawadzkimarki@gmail.com"],
        ["001400", "ezop.ksiegarnia@op.pl"],
        ["001401", "ksiegarniauiwony@op.pl"],
        ["0014772", "sonet@ksiaznica.pl"],
        ["0014773", "sonetjunior@ksiaznica.pl"],
        ["0014822", "egipska@ksiaznica.pl"],
        ["0014875", "gora@biblioart.pl"],
        ["0014876", "milicz@biblioart.pl"],
        ["0014878", "slupca@biblioart.pl"],
        ["0016337", "mak.13@interia.pl"],
        ["0016599", "slawekds7@o2.pl"],
        ["002008", " ph.akcydens@gmail.com"],
        ["002071", "j.lewinski62@gmail.com"],
        ["002080", "maksyma@poczta.onet.pl"],
        ["002096", "krab@ksiegarnienova.pl"],
        ["003342", "lingua@lingua.edu.pl"],
        ["0041188", "hermiona@ksiaznica.pl"],
        ["005223", "wspolczesna@ksiaznica.pl"],
        ["005677", "teczowyksiegarnia@gmail.com"],
        ["006090", "ksiegarniabasia@op.pl"],
        ["0061631", "sklep.bibliotekarium@gmail.com"],
        ["0062911", "papierniczy.kutno@tlen.pl"],
        ["0064355", "ksiegarnia-calineczka@wp.pl"],
        ["007558", "bogdantrzcinski@o2.pl"],
        ["007587", "ksiegarnia.sjo@gmail.com"],
        ["0080373", "kontakt@matfel.pl"],
        ["0080802", "tarnobrzeg@kolibra.pl"],
        ["0080803", "stalowawola@kolibra.pl"],
        ["0081654", "plastus.dzierzgon@gmail.com"],
        ["0083108", "atnaf@o2.pl"],
        ["0084104", "sklep.raszyn@gmail.com"],
        ["0084307", "kropka@ksiaznica.pl"],
        ["009190", "ksiegarnia1@op.pl"],
        ["009942", "rym.p-no@wp.pl"],
        ["010596", "lexica@ksiaznica.pl"],
        ["010671", "biuro@poltax.waw.pl"],
        ["010853", "witold.wietrzynski@gmail.com"],
        ["011011", "zamowienia (zamowienia@wsip.com.pl)"],
        ["011524", "logos@ksiaznica.pl"],
        ["012115", "standard-n@gazeta.pl"],
        ["013147", "elwo17@wp.pl"],
        ["013224", "ksiegarniajola@wp.pl"],
        ["013301", "bozennapajewska@op.pl"],
        ["013328", "basztapultusk@gazeta.pl"],
        ["0133716", "biuro@bookcity.pl"],
        ["013773", "taniaksiazka@op.pl"],
        ["013796", "wena@ksiaznica.pl"],
        ["014135", "abc@ksiaznica.pl"],
        ["015069", "milek1@poczta.onet.eu"],
        ["015324", "best29@wp.pl"],
        ["015515", "agatazd70@gmail.com"],
        ["015516", "saskizbigniew@poczta.onet.pl"],
        ["0157922", "sklep.pisak@o2.pl"],
        ["016189", "fraszka@ksiaznica.pl"],
        ["016191", "odeon@ksiaznica.pl"],
        ["016217", "ks@podreczniki-beniamina.pl"],
        ["020294", "wspolczesna@ksiegarnia.tarnow.pl"],
        ["020384", "ksiegarniaarturszadkowski@vp.pl"],
        ["025449", "popularna@ksiaznica.pl"],
        ["025450", "krasickiego@ksiaznica.pl"],
        ["026410", "czarekbialecki10@op.pl"],
        ["026414", "ksiegarniamaksyma@tlen.pl"],
        ["027330", "ksiegarniatomaszewska@wp.pl"],
        ["027412", "promyknet@op.pl"],
        ["027587", "evelpro@hot.pl"],
        ["027687", "biuro@ksiegarnia-wam.pl"],
        ["028377", "merkuriusz@ksiaznica.pl"],
        ["028384", "ksiegarnia.sochaczew@wp.pl"],
        ["028646", "zamkowa@ksiaznica.pl"],
        ["028900", "1001drobiazgowsc@gmail.com"],
        ["029254", "dk223@ksiegarnienova.pl"],
        ["029386", "dk015@ksiegarnienova.pl"],
        ["029539", "magdaluk@interia.pl"],
        ["029995", "papierowyswiat@vp.pl"],
        ["031579", "bookshop@brytania.com.pl"],
        ["031697", "impuls@ksiaznica.pl"],
        ["031956", "stompel@op.pl"],
        ["032025", "ksiegarniamieszko@interia.pl"],
        ["032328", "5nigcqja6z%@allegromail.pl"],
        ["035747", "ksiegarniaedukacyjna@tlen.pl"],
        ["036293", "krzysztofmurawski1957@gmail.com"],
        ["037455", "pjnug2lbwk%@allegromail.pl"],
        ["040297", "pwarjan@interia.pl"],
        ["0413594", "kasiora87@wp.pl"],
        ["041954", "dz.handlowy@glosel.pl"],
        ["0422979", "sekretariat@englishclub.pl"],
        ["043265", "akme.bis@wp.pl"],
        ["043455", "kleks_mazurek@interia.pl"],
        ["0441838", "ksiegarnia@onet.eu"],
        ["046021", "jakubiak@antyk-wariat.eu"],
        ["0464268", "firmaksiegarska@wp.pl"],
        ["046475", "victoria@ksiaznica.pl"],
        ["046615", "sklep@ksiegarniapodreczniki.pl"],
        ["047134", "ksiegarnia_nowa@poczta.fm"],
        ["0474581", "motosa@wp.pl"],
        ["0477115", "przecinek@ksiaznica.pl"],
        ["0477740", "koscian@biblioart.pl"],
        ["0478107", "rodzinna@ksiaznica.pl"],
        ["0478125", "kociewska@ksiaznica.pl"],
        ["0479590", "powstancow@ksiegarniaorla.pl"],
        ["0479734", "rozawiatrow@ksiaznica.pl"],
        ["049556", "edukom.pulawy@gmail.com"],
        ["053014", "phedukator@o2.pl"],
        ["055010", "sklep-jasimalgosia@wp.pl"],
        ["055730", "ksiegarnia_bzyk@op.pl"],
        ["061122", "ksiegarniaelf@gmail.com"],
        ["065341", "ksiegarnia@ksiegarniaorla.pl"],
        ["068937", "info@ksiegarnia-ekonomiczna.com.pl"],
        ["070511", "ksiegarniaszkoles@wp.pl"],
        ["070803", "ksiegarniatj.wolomin@gmail.com"],
        ["071061", "ksiegarnia.biobit@onet.pl"],
        ["071146", "tomtad0@onet.eu"],
        ["071302", "biuro@artp.com.pl"],
        ["071477", "kleks@onet.pl"],
        ["073156", "mentor@ksiaznica.pl"],
        ["073333", "jantar@ksiaznica.pl"],
        ["073748", "bozena.bondarowicz@interia.pl"],
        ["073796", "vademecumpila@onet.pl"],
        ["074493", "czestochowa@szkolna.net.pl"],
        ["074890", "pabianice@szkolna.net.pl"],
        ["074895", "tarnow@szkolna.net.pl"],
        ["075319", "piotrkow@szkolna.net.pl"],
        ["075394", "rybnik@szkolna.net.pl"],
        ["079954", "j.kawczynska@interia.eu"],
        ["083690", "monika1926@vp.pl"],
        ["090824", "ow.oaza@gmail.com"],
        ["091000", "pegazksie@wp.pl"],
        ["093523", "lesznoosiedlowa@wp.pl"],
        ["094992", "INFO@BC.EDU.PL"],
        ["095154", "horyzont21@gmail.com"],
        ["095495", "robjas5@wp.pl"],
        ["096351", "lidka68@o2.pl"],
        ["096843", "basia4713@wp.pl"],
        ["102103", "ksiegarnia@mechlinski.eu"],
        ["102181", "worldlink@wp.pl"],
        ["105924", "ksimw91@gmail.com"],
        ["106099", "q2f36bu1pf%@allegromail.pl"],
        ["106202", "ksiegarnia.jarosz@wp.pl"],
        ["106242", "pmj.alp@wp.pl"],
        ["106447", "biuro@plimat.pl"],
        ["106536", "xb9klap194%@allegromail.pl"],
        ["108124", "INFO@BOOK.COM.PL"],
        ["112228", "janlus@btinternet.com"],
        ["112244", "alicja.fk@vp.pl"],
        ["112337", "wkaluzny1@wp.pl"],
        ["112338", "wolumengn@post.pl"],
        ["112425", "dorota_malinska@wp.pl; maciejkisielewski@wp.pl"],
        ["112562", "dom.ksiazki@idsl.pl"],
        ["112772", "book.coffee@wp.pl"],
        ["112775", "michal.kielczewski@surf.com.pl"],
        ["112833", "grazyna.gabriel@super-siodemka.pl"],
        ["112924", "ksiegarnia.rawicz@wp.pl"],
        ["115152", "sekretariat@novacentrum.pl"],
        ["115158", "potapski@wp.pl"],
        ["115227", "marba661@wp.pl"],
        ["115235", "zbigzat@wp.pl"],
        ["115953", "ksiegarnia.aga@outlook.com"],
        ["115960", "sirona@sirona.com.pl"],
        ["117462", "ksiegarnia_wolumen@o2.pl"],
        ["117529", "jola_23_03@o2.pl"],
        ["119681", "kozbook@poczta.fm"],
        ["119724", "phu.fajtek@wp.pl"],
        ["119725", "lucynakusnierz@wp.pl"],
        ["119726", "ideandg@wp.pl"],
        ["119737", "ogrody@muza.gda.pl"],
        ["119770", "phlibra@wp.pl"],
        ["119993", "ksiegsezam@op.pl"],
        ["120461", "wiedza101@wp.pl"],
        ["122625", "ksiegarnia@pphuelvis.pl"],
        ["125522", "info@quest.pulawy.pl"],
        ["125533", "sklepmonogram@gmail.com"],
        ["129481", "pimtychy@tlen.pl"],
        ["129484", "biuro@najbar.pl"],
        ["129486", "studniatrzechcesarzy@poczta.fm"],
        ["129490", "ksiegarniasowa1@gmail.com"],
        ["129492", "ksiegarnia@studencka.com.pl"],
        ["129512", "ks_misia@wp.pl"],
        ["129514", "tom.glowacz@interia.pl"],
        ["129520", "czeslawadudziak@poczta.onet.pl"],
        ["129535", "martingliwice@onet.eu"],
        ["129553", "antykwariat73@o2.pl"],
        ["129557", "sowazory@wp.pl"],
        ["129568", "olasklep123@gmail.com"],
        ["130898", "ujacka1@interia.pl"],
        ["131029", "ksiegarniadobrodzien@interia.pl"],
        ["131235", "popnaukowa@ksiaznica.pl"],
        ["136593", "hr@thetower.com.pl"],
        ["136684", "domksiazkikrot@interia.pl"],
        ["136835", "ksiegarnia.szkolna.13@wp.pl"],
        ["142255", "faktura@czytam.pl"],
        ["145074", "oo9blghv4p%@allegromail.pl"],
        ["145828", "ksiegarnia@daniel.net.pl"],
        ["146117", "bajka@ksiaznica.pl"],
        ["146119", "swit@ksiaznica.pl"],
        ["147246", "info@antykwariat-lublin.pl"],
        ["148776", "ksiegarniaalf@wp.pl"],
        ["159368", "moni_76@tlen.pl"],
        ["163260", "ksiegarnia.gemini@interia.pl"],
        ["190219", "ksiegarnia.kaliska@o2.pl"],
        ["213677", "barbara.krakowska@op.pl"],
        ["213811", "abecadlo@ksiaznica.pl"],
        ["217093", "pegaz@ksiaznica.pl"],
        ["230229", "meg7676@wp.pl"],
        ["242215", "robert-osowicz01@tlen.pl"],
        ["256285", "ambaraz@ambaraz.pl"],
        ["257018", "falenica-ksiegarnia@wp.pl"],
        ["257730", "iwonaszerszen@wp.pl"],
        ["259078", "produkty@selkar.pl"],
        ["263381", "bielsko-biala@kolibra.pl"],
        ["263858", "TDK Księgarnia <tdk.ksiazki@gmail.com>"],
        ["264104", "hipogryfa29@gmail.com"],
        ["265658", "chrzanow@kolibra.pl"],
        ["266088", "danuta.konopko@gmail.com"],
        ["266348", "info@antykwariat-archiwum.pl"],
        ["275811", "ksiegarniatetris@wp.pl"],
        ["279250", "adriankotlarz@vp.pl"],
        ["286508", "paweliwaniak@wp.pl"],
        ["294997", "zaopatrzenie@gandalf.com.pl"],
        ["295560", "ksiegarniauleszka@wp.pl"],
        ["295561", "ksiegarniauleszka3@op.pl"],
        ["296325", "ksiegarnia@plus.edu.pl"],
        ["296601", "anetaotlowska@wp.pl"],
        ["297539", "akapit@ksiaznica.pl"],
        ["303490", "cieszyn@kolibra.pl"],
        ["303793", "zenozen@o2.pl"],
        ["304589", "ewa.lawniczak1997@gmail.com"],
        ["306375", "amigopm@op.pl"],
        ["306920", "przemysl@tanie-podreczniki.eu"],
        ["306930", "swiattanichpodrecznikow@wp.pl"],
        ["306934", "kolejowa@tanie-podreczniki.eu"],
        ["308584", "wejherowoksiegarnia@gmail.com"],
        ["309858", "notkapleszew@interia.pl"],
        ["310697", "ksiegarnia.ania@interia.pl"],
        ["311688", "agnieszka@ksiegarniapinokio.pl"],
        ["344525", "gliwice@kolibra.pl"],
        ["345388", "swit683@gmail.com"],
        ["357275", "prymus12zlecenia@o2.pl"],
        ["357940", "literka.ksiegarnia@gmail.com"],
        ["357980", "panksiazkabrzeg@gmail.com"],
        ["358596", "slawek123@poczta.onet.pl"],
        ["358691", "info@fabrykaliteratury.pl"],
        ["359050", "feniks@ksiaznica.pl"],
        ["359096", "akheymann@interia.pl"],
        ["359334", "czeslaw.handel@wp.pl"],
        ["359754", "antykwariatgorzow@onet.pl"],
        ["359889", "katarzyna_swiderek@o2.pl"],
        ["361492", "literka@ksiaznica.pl"],
        ["377389", "zaopatrzenie@itidea.biz"],
        ["383542", "ksiegarnia_atut@poczta.onet.pl"],

    ]; */

    $users_data = [
        ["0081391", "andrzej.filipiak7@wp.pl"],
        ["357914", "daria.oleszko@gmail.com"],
        ["070716", "korob@korob.pl"]
    ];



    foreach ($users_data as $user) {

        $email = $user[1];
        $logo = $user[0];
        $password = "$" . $logo . "qsc";

        //CustomerUser::createAndAddContractor($email, $email, $password, $logo);
    }

    return $users_data;
});
