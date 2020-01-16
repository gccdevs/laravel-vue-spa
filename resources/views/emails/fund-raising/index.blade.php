@extends('emails.base')

@section('content')
@php
if(!isset($lang)) {
    $lang = null;
}
@endphp
    <div class="row">
        <div class="col-md-12">
            <div class="invoice-title">
                @if($lang == 'en')
                    <h3>Receipt <br><p>#: {{ $transaction->transaction_uuid }}</p></h3>
                @else
                    <h3>墨爾本榮耀城教會<br>建堂奉獻收據 <p>#: {{ $transaction->transaction_uuid }}</p></h3>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <hr>
                <div class="panel-heading">
                    @if($lang == 'en')
                        <h3 class="panel-title"><strong>Payment Information</strong></h3>
                    @else
                        <h3 class="panel-title"><strong>支付信息</strong></h3>
                    @endif
                </div>
                <div class="panel-body">
                    @if($lang == 'en')
                    Thanks for your generosity!
                    <br><br>
                    We have received your <b>{{ 'A$' . monie_format(round_up($transaction->transaction_amount_paid / 100, 2)) }}</b>. 
                    <br>They have been saved into your online account.
                    <br><br>
                    @else
                    感謝您的奉獻！
                    <br><br>
                    非常感恩您加入我們，一起為榮耀城的新家添磚加瓦，您的 <b>{{ 'A$' . monie_format(round_up($transaction->transaction_amount_paid / 100, 2)) }}</b> 奉獻已經存入我們的建堂募款帳戶，它將完全用於榮耀城教會新址的裝修工程。
                    <br><br>
                    感謝主可以讓我們在合一的靈裡一起同工，為主贏得更多墨爾本的華人，將耶穌的愛傳遞給他們，如同光照在人前，翻轉他們的生命，成為這世代的領袖！我們相信，這正是主所喜悅的。
                    <br><br>
                    願上帝親自的紀念你，祝福你。
                    <br><br>
                    再次感謝您的參與。
                    <br><br>
                    感谢您的慷慨奉献！
                    <br><br>
                    @endif
                    <b>{{ date('Y-m-d H:i:s', strtotime($transaction->created_at)) }}</b>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <hr>
                <div class="panel-heading">
                    @if($lang == 'en')
                    <h3 class="panel-title"><i>About Us</i></h3>
                    @else
                    <h3 class="panel-title"><i>这是我們的故事</i></h3>
                    @endif
                </div>
                <div class="panel-body">
                    @if($lang == 'en')
                    <div class="inner" style="white-space: pre-wrap;max-width: 960px;margin: 0 auto;">
We are on a mission!

Since the establishment of "Glory City Church of Melbourne" in 2012, we have grown from just 2 people to nearly 100 people, and from students to a range of students, young adults, and young families, with lots of babies growing up very fast.

We believe we are called to plant the church in the heart of the city as a strategic place to win a new generation for Jesus, where the students and young professionals gather, and where the voices of this generation is being expressed and heard.

With this in mind, we strongly believe that we need to expand our space and create a more welcoming and open home to reach the community and engage with this city, in particularly with the Chinese communities whom God has called us to serve.

With a total of $200,000 AUD to renovate our new home, we have seen the strong faith and passion for this vision from all the young people in our congregation, raising a total of $75,000 AUD in just one month, but we also believe that God is inviting other people in His Kingdom to invest and participate in this mission.

Join us, and create a space to transform a generation!

Glory City Church was established by Ps Joseph Chen and his wife, Deborah, with a vision to see a new generation of disciples that will be Salt & Light to the World through everyday discipleship lifestyle, and making impact in all areas of society.

As an Ethnic Church called to serve Mandarin speaking people (from China, HK, Taiwan, Malaysia, Singapore...etc), we have a strong conviction to help the Chinese community to have a renewed mindset as immigrants to not just take what they came here for, but to be rooted in this land, to love the people of this land, and to bless God's work that is established on this land as the "promised land" for all migrants coming to start a new life.

We strongly believe that this new place will become a crucial foundation for all the work to be done in this ministry:

<b>Community Centre</b> :: To reach and impact the community around us and in the heart of this wonderful city.
<b>Healing Centre</b> :: To encourage and restore many lives to live their life to the full according to God's creation plan.
<b>Training Centre</b> :: To equip disciples and empower leaders to do what God has called them to do, whether in Australia, or being sent overseas.
<b>Mission Centre</b> :: To establish a network of mission works around Australia, and around the World, especially mobilising the Chinese churches
<br><br>
</div>
                    @else
                    <i style="color: gray;">
                        六年前，因著上帝給的異象，Joseph牧師和妻子Deborah，在墨爾本市中心，年輕人最多學校最集中的地區之一創立了墨爾本榮耀城教會。那時雖然財物匱乏，但因著對上帝完全的信心和順服，這間非常年輕，主要服侍在澳華人的教會就這樣慢慢成長起來。
                        馬太福音5:14-16說：
                        <br><br>
                        <div class="email-quotation">
                            “你們是世上的光。城造在山上是不能隱藏的。人點燈，不放在斗底下，是放在燈臺上，就照亮一家的人。你們的光也當這樣照在人前，叫他們看見你們的好行為，便將榮耀歸給你們在天上的父。 ”
                        </div>
                        <br><br>        
                        起名榮耀城，便是因為上帝賦予我們教會的異象，我們相信每一個年輕人都是上帝極為看重的，可以成為神合用的器皿，興起發光，在世人面前作神榮耀的見證，成為影響這一整個時代的領袖。我們也相信，教會就是一群合神心意的人聚集在一起，我們雖身在世界，卻可以活出屬天的生活，讓神的榮耀因著榮耀城和众教會，彰顯在這地。
                        <br><br>
                        過去的那六年時間，榮耀城經歷了各樣的祝褔與成長，有100多位弟兄姊妹們參與到我們當中，經歷神的愛，生命被翻轉，又把神的愛繼續傳遞出去。榮耀城透過與十多個非營利機構合作，組織愛心義賣，長城義走，領養貧困兒童，參訪老人院，免費招待大學生，辦公益健康講座等，基於真理，用實際行動活出上帝對這地的深深的愛。
                        <br><br>
                        六年後，時間到了！ 神給了我們一個更大的教會場地。
                        <br><br>
                        同時我們也邀請你持續的為榮耀城禱告，求神不斷擴張我們的信心，挑望我們的熱情，讓我們在每一個細節上都行在神的心意裡，做祂的好管家，智慧的使用祂賦予我們的資源和能力。讓我們在墨爾本為主興起，像光照在人前，做神榮耀的見證。
                        <br><br>
                    </i>
                    <hr>
                    新场地地址 - 601-603 Elizabeth Street, Melbourne 3000
                    <br><br>
                    我們的募款目標為： $100,000 AUD
                    我們的募款期限為 2018年11月底
                    <br><br>
                    歡迎大家至我們募款網頁奉獻：<a href="https://hub.glorycitychurch.com/arise-and-shine">https://hub.glorycitychurch.com/arise-and-shine</a>
                    <br><br>
                    或選擇轉賬方式:<br><br>
                    Account Name: Glory City Church of Melbourne Inc.<br><br>
                    BSB: 033-005<br><br>
                    SWIFT CODE: WPACAU2S 或者 WPACAU2SXXX<br><br>
                    Account Number: 427741<br><br>
                    注明: Arise<br><br>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
