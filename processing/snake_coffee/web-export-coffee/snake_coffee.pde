class Bar
    constructor: (@l, @vr, @cx = 0, @cy = 0, @r = 0) ->
  
    getEndPoint: -> [@l * cos(@r) + @cx, @l * sin(@r) + @cy]

    draw: ->
        [ex, ey] = @getEndPoint()
        line @cx, @cy, ex, ey
        [ex, ey]

setup: ->

    size 640, 640
    stroke 255
    @snake = (new Bar(5, random -0.01, 0.01) for _ in [1..3000])

draw: ->

    background 0
    [cx, cy] = [width / 2, height / 2]
    for bar in @snake
        [bar.cx, bar.cy] = [cx, cy]
        bar.r += bar.vr
        [cx, cy] = bar.draw()

