@if(config('laravel-decoda.bbcode.enabled'))
    <script src="{{asset('vendor/mandark/laravel-decoda/js/wysibb/jquery.wysibb.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var wbbOpt = {
                buttons: "{{
                    (config('laravel-decoda.bbcode.tags.b')?'bold,':'').
                    (config('laravel-decoda.bbcode.tags.i')?'italic,':'').
                    (config('laravel-decoda.bbcode.tags.u')?'underline,':'').
                    (config('laravel-decoda.bbcode.tags.s')?'strike,':'').
                    (config('laravel-decoda.bbcode.tags.sup')?'sup,':'').
                    (config('laravel-decoda.bbcode.tags.sub')?'sub,':'')
                }},|,{{
                    (config('laravel-decoda.bbcode.tags.img')?'img,':'').
                    (config('laravel-decoda.bbcode.tags.video')?'video,':'').
                    (config('laravel-decoda.bbcode.tags.url')?'link,':'')
                }},|,{{
                    (config('laravel-decoda.bbcode.tags.list')?'bullist,':'').
                    (config('laravel-decoda.bbcode.tags.olist')?'numlist,':'')
                }},|,{{
                    (config('laravel-decoda.bbcode.tags.font')?'fontfamily,':'').
                    (config('laravel-decoda.bbcode.tags.size')?'fontsize,':'').
                    (config('laravel-decoda.bbcode.tags.color')?'fontcolor,':'')
                }},|,{{
                    (config('laravel-decoda.bbcode.tags.left')?'justifyleft,':'').
                    (config('laravel-decoda.bbcode.tags.center')?'justifycenter,':'').
                    (config('laravel-decoda.bbcode.tags.right')?'justifyright,':'')
                }},|,{{
                    (config('laravel-decoda.bbcode.tags.quote')?'quote,':'').
                    (config('laravel-decoda.bbcode.tags.code')?'code,':'').
                    (config('laravel-decoda.bbcode.tags.table')?'table,':'')
                }},|,{{
                    (config('laravel-decoda.emoticons.enabled')?'smilebox,':'')
                }},|,removeFormat",
                smileList:
                        [
                            @foreach(config('laravel-decoda.emoticons.list') as $name => $smileys)
                                {title:CURLANG.{{$name}}, img: '<img src="{{asset(config('laravel-decoda.emoticons.path').$name.'.png')}}" class="sm">', bbcode:" :{{$name}}: "},
                            @endforeach
                        ],
                allButtons: {
                    quote: {
                        transform: {

                            '{!! preg_replace( "/\r|\n/", "", view('forum::bbcode.quote')->with(['content'=>'{SELTEXT}'])->render()) !!}':'[quote]{SELTEXT}[/quote]',
                            '{!! preg_replace( "/\r|\n/", "", view('forum::bbcode.quote')->with(['content'=>'{SELTEXT}','author'=>'{AUTHOR}'])->render()) !!}':'[quote={AUTHOR}]{SELTEXT}[/quote]',
                        }
                    },
                    video: {
                        transform: {
                            '{!! preg_replace( "/\r|\n/", "", view('forum::bbcode.video')->with(['url'=>'http://www.youtube.com/embed/{SRC}','player'=>'iframe'])->render()) !!}':'[youtube]{SRC}[/youtube]'
                        }
                    },
                    numlist : {
                        transform : {
                            '<ol>{SELTEXT}</ol>':"[olist]{SELTEXT}[/olist]",
                            '<li>{SELTEXT}</li>':"[*]{SELTEXT}[/*]"
                        }
                    },

                    // Adapt size options to the ones accepted by decoda.
                    fs_verysmall: {
                        transform: {
                            '<font size="1">{SELTEXT}</font>':'[size=10]{SELTEXT}[/size]'
                        }
                    },
                    fs_small: {
                        transform: {
                            '<font size="2">{SELTEXT}</font>':'[size=12]{SELTEXT}[/size]'
                        }
                    },
                    fs_normal: {
                        transform: {
                            '<font size="3">{SELTEXT}</font>':'[size=14]{SELTEXT}[/size]'
                        }
                    },
                    fs_big: {
                        transform: {
                            '<font size="4">{SELTEXT}</font>':'[size=17]{SELTEXT}[/size]'
                        }
                    },
                    fs_verybig: {
                        transform: {
                            '<font size="6">{SELTEXT}</font>':'[size=20]{SELTEXT}[/size]'
                        }
                    },
                }
            };
            $("[data-add-wysibb]").wysibb(wbbOpt)

            $('a[data-decodaquickquote]').click(function(event) {
                var idTextarea = $(this).attr('href');
                var jqTextarea = $(idTextarea);
                var idQuote = $(this).data('decodaquickquote');
                var quote = $(idQuote).html().trim();
                $('html,body').animate({scrollTop: jqTextarea.parent().offset().top});
                jqTextarea.insertAtCursor(quote,true)
            });
        })
    </script>
@endif