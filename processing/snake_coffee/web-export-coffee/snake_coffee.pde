class Bar
    constructor: (@cx, @cy, @l) ->
        @r = 0
        @vr = 0
  
    getEndPoint: -> [@l * cos(@r) + @cx, @l * sin(@r) + @cy]

    draw: ->
        [ex, ey] = @getEndPoint()
        line @cx, @cy, ex, ey
        [ex, ey]

setup: ->

    size 640, 640

    @snake = []
    [cx, cy] = [width / 2, height / 2]
    for i in [0..1000] # 10000 runs slow...
        bar = new Bar(cx, cy, 5)
        bar.r = 0;
        bar.vr = random -0.01, 0.01
        @snake.push bar
        [cx, cy] = bar.getEndPoint()

    stroke 255

draw: ->

    background 0
    for i in [0...@snake.length]
        bar = @snake[i]
        bar.r += bar.vr
        [ex, ey] = bar.draw()
        if i < @snake.length - 1
            next = @snake[i+1] 
            [next.cx, next.cy] = [ex, ey]

