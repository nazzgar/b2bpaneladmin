<?php

use App\Settings\ReturnLimits;
use B2BPanel\SharedModels\CustomerUser;
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


Route::get('/seed', function () {
    //$users_data = [["000190", "papirusnatolin@gmail.com"], ["000833", "ksiegarnia_paulina@o2.pl"], ["000878", "krisdruk@post.pl"], ["001114", "hurtownia.marko@wp.pl"], ["001159", "wiesiakwolek@gmail.com"], ["001244", "ksiegarniaesej@wp.pl"], ["001388", "wsp.siedlce@wp.pl"], ["001398", "marcinzawadzkimarki@gmail.com"], ["001401", "ksiegarniauiwony@op.pl"], ["002071", "j.lewinski62@gmail.com"], ["002080", "maksyma@poczta.onet.pl"], ["005677", "teczowyksiegarnia@gmail.com"], ["006090", "ksiegarniabasia@op.pl"], ["0061631", "sklep.bibliotekarium@gmail.com"], ["0080373", "kontakt@matfel.pl"], ["009190", "ksiegarnia1@op.pl"], ["009942", "rym.p-no@wp.pl"], ["010853", "witold.wietrzynski@gmail.com"], ["013147", "elwo17@wp.pl"], ["013224", "ksiegarniajola@wp.pl"], ["013301", "bozennapajewska@op.pl"], ["013773", "taniaksiazka@op.pl"], ["015324", "best29@wp.pl"], ["015515", "agatazd70@gmail.com"], ["015516", "saskizbigniew@poczta.onet.pl"], ["016217", "ks@podreczniki-beniamina.pl"], ["020384", "ksiegarniaarturszadkowski@vp.pl"], ["027330", "ksiegarniatomaszewska@wp.pl"], ["027587", "evelpro@hot.pl"], ["029995", "papierowyswiat@vp.pl"], ["041954", "dz.handlowy@glosel.pl"], ["053014", "phedukator@o2.pl"], ["055730", "ksiegarnia_bzyk@op.pl"], ["061122", "ksiegarniaelf@gmail.com"], ["070716", "korob@korob.pl"], ["070803", "ksiegarniatj.wolomin@gmail.com"], ["071146", "tomtad0@onet.eu"], ["073748", "bozena.bondarowicz@interia.pl"], ["073796", "vademecumpila@onet.pl"], ["095154", "horyzont21@gmail.com"], ["096351", "lidka68@o2.pl"], ["102181", "worldlink@wp.pl"], ["106242", "pmj.alp@wp.pl"], ["112244", "alicja.fk@vp.pl"], ["112338", "wolumengn@post.pl"], ["112562", "dom.ksiazki@idsl.pl"], ["115227", "marba661@wp.pl"], ["115235", "zbigzat@wp.pl"], ["117462", "ksiegarnia_wolumen@o2.pl"], ["119724", "phu.fajtek@wp.pl"], ["119726", "ideandg@wp.pl"], ["119993", "ksiegsezam@op.pl"], ["120461", "wiedza101@wp.pl"], ["129553", "antykwariat73@o2.pl"], ["129557", "sowazory@wp.pl"], ["131235", "popnaukowa@ksiaznica.pl"], ["136684", "domksiazkikrot@interia.pl"], ["142255", "faktura@czytam.pl"], ["145074", "eger_zamosc@o2.pl"], ["147246", "info@antykwariat-lublin.pl"], ["148776", "ksiegarniaalf@wp.pl"], ["190219", "ksiegarnia.kaliska@o2.pl"], ["213677", "barbara.krakowska@op.pl"], ["230229", "meg7676@wp.pl"], ["242215", "robert-osowicz01@tlen.pl"], ["263858", "tdk.ksiazki@gmail.com"], ["266088", "danuta.konopko@gmail.com"], ["275811", "ksiegarniatetris@wp.pl"], ["279250", "adriankotlarz@vp.pl"], ["295560", "ksiegarniauleszka@wp.pl"], ["296601", "anetaotlowska@wp.pl"], ["304589", "ewa.lawniczak1997@gmail.com"], ["306375", "amigopm@op.pl"], ["308584", "wejherowoksiegarnia@gmail.com"], ["310697", "ksiegarnia.ania@interia.pl"], ["345388", "swit683@gmail.com"], ["357914", "daria.oleszko@gmail.com"], ["359334", "czeslaw.handel@wp.pl"]];
    $users_data = [
        /* ["0001312", "avalonstary@ksiaznica.pl"],
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
        ["0478107", "rodzinna@ksiaznica.pl"], */
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
    ];

    foreach ($users_data as $user) {

        $email = $user[1];
        $logo = $user[0];
        $password = "$" . $logo . "qsc";

        //CustomerUser::createAndAddContractor($email, $email, $password, $logo);
    }

    return $users_data;
});
