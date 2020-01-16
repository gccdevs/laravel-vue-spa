<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="0GpBXCAEuCSGEPme_w6P4Vi71VidxH8gdAHzM1LPyK8" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/logo--short.png') }}">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2" rel="stylesheet" type="text/css">

    @routes

    <!-- app js values -->
    <script type="application/javascript">
        var ALLOW_VUE_CACHE = "{{ env('ALLOW_VUE_CACHE') }}";
        var ENV = "{{ env('APP_ENV') }}";
        var Laravel = {};
        Laravel.apiToken = "{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}";
        Laravel.APP_URL = '{{env('APP_URL')}}';
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .custom-nav-drawer a.router-link:hover > div {
            color: rgb(75, 95, 226);
            background: #fafafa !important;
        }
        .list .list__tile--link:hover {
            background: #fafafa !important;
        }
        .navigation-drawer__border {
            display: none !important;
        }
    </style>
</head>
<body>
<div id="admin">

    <template>
        <v-app id="inspire">
            <v-navigation-drawer clipped fixed v-model="drawer" class="custom-nav-drawer" style="width:200px;background-color: rgb(250, 250, 250);" app>
                <v-list dense>
                    @foreach($nav as $n)
                        @if($n->navType==\App\Components\Core\Menu\MenuItem::$NAV_TYPE_NAV)
                            <router-link :to="{name:'{{ $n->routeName }}'}" class="router-link">
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-icon>{{$n->icon}}</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{$n->label}}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                        @else
                        @endif
                    @endforeach

                    {{--<a class="router-link">--}}
                        {{--<v-list-tile @click="clickLogout('{{route('logout')}}','{{url('/')}}')">--}}
                            {{--<v-list-tile-action>--}}
                                {{--<v-icon>directions_walk</v-icon>--}}
                            {{--</v-list-tile-action>--}}
                            {{--<v-list-tile-content>--}}
                                {{--<v-list-tile-title>Logout</v-list-tile-title>--}}
                            {{--</v-list-tile-content>--}}
                        {{--</v-list-tile>--}}
                    {{--</a>--}}
                </v-list>
            </v-navigation-drawer>
            <v-toolbar app fixed clipped-left>
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                <v-toolbar-title><a href="{{ env('APP_URL') . '/admin' }}" class="home-link">{{config('app.name')}}</a></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items class="hidden-sm-and-down">
                    <v-avatar color="grey lighten-4" style="margin-top: 5px;">
                        <img src="https://avatars0.githubusercontent.com/u/9064066?v=4&s=460" alt="avatar">
                    </v-avatar>
                    <v-menu offset-y>
                      <v-btn
                        slot="activator"
                        flat>
                        {{ __('nav.switchLanguage') }}
                      </v-btn>
                      <v-list>
                        <v-list-tile v-on:click="switchLang('tw')">
                          <v-list-tile-title>繁體中文</v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile v-on:click="switchLang('zh')">
                          <v-list-tile-title>简体中文</v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile v-on:click="switchLang('en')">
                          <v-list-tile-title>English</v-list-tile-title>
                        </v-list-tile>
                      </v-list>
                    </v-menu>
                    <v-btn flat v-on:click="changePassword">修改密码</v-btn>
                    <v-btn flat @click="clickLogout('{{route("logout")}}')">{{ __('auth.logout') }}</v-btn>
                </v-toolbar-items>
            </v-toolbar>
                <v-content>
                    <transition name="fade">
                        <router-view></router-view>
                    </transition>
                </v-content>
            <v-footer app justify-center>
                <span>&copy; 2018 Glory City Church Inc.</span>
            </v-footer>
        </v-app>

        <!-- loader -->
        <div v-if="showLoader" class="wask_loader bg_half_transparent">
            <moon-loader color="red"></moon-loader>
        </div>

        <ui-password-modal :key="passwordRef" ref="passwordChange" :dialog="showPasswordModal" @close="passwordModalClose"></ui-password-modal>

    </template>
</div>

<!-- Scripts -->
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/backend.js') }}"></script>
</body>
</html>