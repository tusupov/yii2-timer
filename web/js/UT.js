
//User Time
var UT = function() {

    this.refreshTime = 60;
    this.refreshUrl  = "/site/refreshtime";

    this.timeFlag       = "time";
    this.localTimeFlag  = "UT_local_time";

    this.selector       = ".ut"

};

UT.prototype.refreshTimeFunc = function() {

    var data = {};
    data[this.timeFlag] = localStorage[this.localTimeFlag]

    $.post(
        this.refreshUrl,
        data
    )

}

UT.prototype.startFunc = function (timeFlag, userServerTime) {

    if (!timeFlag) return;

    var UT = this;

    UT.timeFlag       = timeFlag
    UT.localTimeFlag  = "UT_local_" + timeFlag

    UT.startTime = Math.floor((new Date()).getTime() / 1000)

    var serverTime = +userServerTime || 0,
        localTime  = +localStorage[UT.localTimeFlag] || 0;

    var currectTime = Math.max(localTime, serverTime);

    var interval = function(){

        var distance = localStorage[UT.localTimeFlag];

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

        $(UT.selector).html(html)

        localStorage[UT.localTimeFlag] = ++currectTime;

        if (localStorage[UT.localTimeFlag] % UT.refreshTime == 0)
            UT.refreshTimeFunc()

        setTimeout(interval, 1000)

    }

    interval()

};
