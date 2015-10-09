@if(config('bbcode.bbcode.enabled'))
    <script src="{{asset('vendor/mandark/laravel-decoda/js/wysibb/jquery.wysibb.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var wbbOpt = {
                buttons: "{{
                    (config('bbcode.bbcode.tags.b')?'bold,':'').
                    (config('bbcode.bbcode.tags.i')?'italic,':'').
                    (config('bbcode.bbcode.tags.u')?'underline,':'').
                    (config('bbcode.bbcode.tags.s')?'strike,':'').
                    (config('bbcode.bbcode.tags.sup')?'sup,':'').
                    (config('bbcode.bbcode.tags.sub')?'sub,':'')
                }},|,{{
                    (config('bbcode.bbcode.tags.img')?'img,':'').
                    (config('bbcode.bbcode.tags.video')?'video,':'').
                    (config('bbcode.bbcode.tags.url')?'link,':'')
                }},|,{{
                    (config('bbcode.bbcode.tags.list')?'bullist,':'').
                    (config('bbcode.bbcode.tags.olist')?'numlist,':'')
                }},|,{{
                    (config('bbcode.bbcode.tags.font')?'fontfamily,':'').
                    (config('bbcode.bbcode.tags.size')?'fontsize,':'').
                    (config('bbcode.bbcode.tags.color')?'fontcolor,':'')
                }},|,{{
                    (config('bbcode.bbcode.tags.left')?'justifyleft,':'').
                    (config('bbcode.bbcode.tags.center')?'justifycenter,':'').
                    (config('bbcode.bbcode.tags.right')?'justifyright,':'')
                }},|,{{
                    (config('bbcode.bbcode.tags.quote')?'quote,':'').
                    (config('bbcode.bbcode.tags.code')?'code,':'').
                    (config('bbcode.bbcode.tags.table')?'table,':'')
                }},|,{{
                    (config('bbcode.emoticons.enabled')?'smilebox,':'')
                }},|,removeFormat",
                smileList:
                        [
                            @foreach(config('bbcode.emoticons.list') as $name => $smileys)
                                {title:CURLANG.{{$name}}, img: '<img src="{{asset(config('bbcode.emoticons.path').$name.'.png')}}" class="sm">', bbcode:" :{{$name}}: "},
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

            $('a[data-bbcodequickquote]').click(function(event) {
                var idTextarea = $(this).attr('href');
                var jqTextarea = $(idTextarea);
                var idQuote = $(this).data('bbcodequickquote');
                var quote = $(idQuote).html().trim();
                $('html,body').animate({scrollTop: jqTextarea.parent().offset().top});
                jqTextarea.insertAtCursor(quote,true)
            });
        })
    </script>
@endif