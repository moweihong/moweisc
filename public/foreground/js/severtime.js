    var aq = $("#pServerTime");
    if (aq.length > 0) {
        var m = aq.children("span");
            var aC = function() {
                var aG = new Date();
                aG.setSeconds(aG.getSeconds()+0);
                var aF = aG.getHours();
                var aE = aG.getMinutes();
                var aH = aG.getSeconds();
                m.eq(0).html(aF > 9 ? aF.toString() : "0" + aF);
                m.eq(1).html(aE > 9 ? aE.toString() : "0" + aE);
                m.eq(2).html(aH > 9 ? aH.toString() : "0" + aH)
            };
            setInterval(aC, 1000);
    }