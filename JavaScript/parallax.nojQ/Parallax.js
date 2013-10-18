var Parallax = function(head, lx, ly) {
    this.head = head;
    this.lx = lx;
    this.ly = ly;

    function setup(head)
    {
        var children = head.children;
        var len = children.length;
        for (var i = 0; i < len; i++) {
            var elem = children[i];
            //if (elem.hasAttribute('depth')) { //IE7で動かない
            if (elem.getAttributeNode('depth')) {
                var rect = elem.getBoundingClientRect();
                elem.setAttribute('__offsetTop', rect.top)
                elem.setAttribute('__offsetLeft', rect.left);
                if (elem.style.position == 'static') {
                    elem.style.position = 'relative';
                    elem.style.top = 0;
                    elem.style.left = 0;
                }
            }
            setup(elem);
        }
    }
    setup(head);
};
Parallax.prototype = {
    move: function(ex, ey)
    {
        var lx = this.lx;
        var ly = this.ly;

        function move(head)
        {
            var children = head.children;
            var len = children.length;
            for (var i = 0; i < len; i++) {
                var elem = children[i];
                //if (elem.hasAttribute('depth')) { //IE7で動かない
                if (elem.getAttributeNode('depth')) {
                    var offsetTop = elem.getAttribute('__offsetTop');
                    var offsetLeft = elem.getAttribute('__offsetLeft');
                    var depth = elem.getAttribute('depth');
                    var dx = lx - depth;
                    var dy = ly - depth;
                    var top = depth * (offsetTop - ey) / dy;
                    var left = depth * (offsetLeft - ex) / dx;
                    elem.style.top = Math.floor(top) + 'px';
                    elem.style.left = Math.floor(left) + 'px';
                }
                move(elem);
            }
        }
        move(this.head);
    } /* ここに ',' を書きたいけれど、IE7以前だと動かなくなる */
};
