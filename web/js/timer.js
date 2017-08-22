$(function(){

    //Все элементы связанный с таймером
    $('[data-time]').each(function(){

        var $this = $(this),
            time = +$this.data("time") //начала отсчета

        //Если не число останавливаем
        if (isNaN(time)) return;

        var intervalFnc = function() {

            var now      = Math.floor( new Date().getTime() / 1000 ), //Текущая время
                distance = now - time;

            var timer = [];

            //Все (день, час, минут, секунд)
            timer.push(Math.floor( distance / (60 * 60 * 24) ))
            timer.push(Math.floor( (distance % (60 * 60 * 24)) / (60 * 60)))
            timer.push(Math.floor( (distance % (60 * 60)) / 60))
            timer.push(Math.floor( distance % 60 ))

            //Добавляем перед нули если меньше 10
            for (var i = 1; i < timer.length; i++)
                if (timer[i] < 10)
                    timer[i] = "0" + timer[i]

            var html = "";

            if (timer[0] > 0)
                html += "<span class='days'>" + timer[0] + "</span> д. "

            html += "<span class='hours'>" + timer[1] + "</span>:" +
                    "<span class='minutes'>" + timer[2] + "</span>:" +
                    "<span class='seconds'>" + timer[3] + "</span>"

            //Показываем результат
            $this.html(html)

        }

        //Сразу показываем
        intervalFnc()

        //Устанавливаем интервал
        setInterval(intervalFnc, 1000)

    });

})