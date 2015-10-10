<script src="{{asset('vendor/mandark/bbcode/js/wysibb/jquery.wysibb.min.js')}}"></script>
<script>
    $(document).ready(function() {
        var wbbOpt = {
            buttons: "{{
                (config('bbcode.tags.b')?'bold,':'').
                (config('bbcode.tags.i')?'italic,':'').
                (config('bbcode.tags.u')?'underline,':'').
                (config('bbcode.tags.s')?'strike,':'').
                (config('bbcode.tags.sup')?'sup,':'').
                (config('bbcode.tags.sub')?'sub,':'')
            }},|,{{
                (config('bbcode.tags.img')?'img,':'').
                (config('bbcode.tags.video')?'video,':'').
                (config('bbcode.tags.url')?'link,':'')
            }},|,{{
                (config('bbcode.tags.list')?'bullist,':'').
                (config('bbcode.tags.olist')?'numlist,':'')
            }},|,{{
                (config('bbcode.tags.font')?'fontfamily,':'').
                (config('bbcode.tags.size')?'fontsize,':'').
                (config('bbcode.tags.color')?'fontcolor,':'')
            }},|,{{
                (config('bbcode.tags.left')?'justifyleft,':'').
                (config('bbcode.tags.center')?'justifycenter,':'').
                (config('bbcode.tags.right')?'justifyright,':'')
            }},|,{{
                (config('bbcode.tags.quote')?'quote,':'').
                (config('bbcode.tags.code')?'code,':'').
                (config('bbcode.tags.table')?'table,':'')
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

                        '{!! preg_replace( "/\r|\n/", "", view('bbcode::quote')->with(['content'=>'{SELTEXT}'])->render()) !!}':'[quote]{SELTEXT}[/quote]',
                        '{!! preg_replace( "/\r|\n/", "", view('bbcode::quote')->with(['content'=>'{SELTEXT}','author'=>'{AUTHOR}'])->render()) !!}':'[quote={AUTHOR}]{SELTEXT}[/quote]',
                    }
                },
                video: {
                    transform: {
                        '{!! preg_replace( "/\r|\n/", "", view('bbcode::video')->with(['url'=>'http://www.youtube.com/embed/{SRC}','player'=>'iframe'])->render()) !!}':'[youtube]{SRC}[/youtube]'
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

        $("[data-add-wysibb]").closest('form').find('[type="submit"]').click(function( event ) {

            $(this).closest('form').find('[data-add-wysibb]').each(function( index ) {
                var content = $(this).siblings('.wysibb-body').text();
                $(this).val(content);
            });

        });
    })
</script>