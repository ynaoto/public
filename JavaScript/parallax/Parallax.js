var Parallax = function($head, lx, ly) {
    this.$head = $head;
    this.lx = lx;
    this.ly = ly;

    function setup($head)
    {
        $head.children().each(function(idx, elem) {
            var $elem = $(elem);
            if ($elem.attr('depth')) {
                $elem.attr('__offsetTop', $elem.offset().top)
                     .attr('__offsetLeft', $elem.offset().left);
                if ($elem.css('position') == 'static') {
                    $elem.css('position', 'relative')
                         .css('top', 0)
                         .css('left', 0);
                }
            }
            setup($elem);
        });
    }
    setup($head);
};
Parallax.prototype = {
    move: function(ex, ey)
    {
        var lx = this.lx;
        var ly = this.ly;

        function move($head)
        {
            $head.children().each(function(idx, elem) {
                var $elem = $(elem);
                if ($elem.attr('depth')) {
                    var offsetTop = $elem.attr('__offsetTop');
                    var offsetLeft = $elem.attr('__offsetLeft');
                    var depth = $elem.attr('depth');
                    var dx = lx - depth;
                    var dy = ly - depth;
                    var top = depth * (offsetTop - ey) / dy;
                    var left = depth * (offsetLeft - ex) / dx;
                    $elem.css('top', Math.floor(top) + 'px')
                         .css('left', Math.floor(left) + 'px');
                }
                move($elem);
            });
        }
        move(this.$head);
    } /* ここに ',' を書きたいけれど、IE7以前だと動かなくなる */
};
