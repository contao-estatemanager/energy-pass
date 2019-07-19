document.addEventListener("DOMContentLoaded", function(event) {
    var energieBar = document.getElementById('expose-energiebar');

    if(energieBar){
        var pointer = energieBar.querySelector('.pointer'),
            items = energieBar.querySelectorAll('.bar > .item'),
            barWidth = energieBar.querySelector('.bar').offsetWidth,

            itemOffsetWidth = 0,
            prevVal = 0,
            currVal = 0,
            val = parseFloat(pointer.dataset.value.replace(',','.')),

            offsetPercent = 0,
            offsetLeft = 0,
            offsetWidth = 0,

            i = 0;

        if(val > 249){
            pointer.style.marginLeft = 100 / barWidth * (barWidth - pointer.offsetWidth) + "%";
        }else{
            for(; i<items.length; i++){
                currVal = parseInt(items[i].dataset.value.replace( /\D/g , ''));

                if(val > currVal){
                    prevVal = currVal;
                    itemOffsetWidth += items[i].offsetWidth;
                }else{
                    offsetPercent = (val - prevVal) + (currVal / (currVal - prevVal));
                    offsetWidth = (items[i].offsetWidth / 100 * offsetPercent) + itemOffsetWidth;
                    offsetLeft = 100 / barWidth * offsetWidth;

                    pointer.style.marginLeft = offsetLeft + '%';
                    break;
                }
            }
        }
    }
});