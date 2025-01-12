"use strict";


function viewThousandsSeparator(x, y=0, show='') {
    //remove commas
    let retVal=0;
    if(x==null || x=='' || x==undefined){
        if(show=='0'){
            var ret = show;
        }else{
            var ret = '';
        }
        return ret;
    }
    const string = ""+x;
    const substring = ".";
    if(!string.includes(substring)){
        x += '.00';
    }
    x = parseFloat(x).toFixed(y);

    var koma = x.split('.');

    retVal = x ? parseFloat(koma[0].replace(/,/g, '')) : 0;
    //apply formatting
    var ret =  retVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    if(ret=='NaN'){
        if(show!=''){
            var ret = show;
        }else{
            var ret = '';
        }
        return ret;
    }else{
        if(koma.length > 1 && y > 0){
            if(koma[1].length > 3){
                var a = parseFloat('0,'+koma[1]).toFixed(y);
                var b = a.split(',');
                var com = ',' + b[1];
            }else{
                var com = ',' + koma[1];
            }
        }else{
            var com = '';
        }
        var ret = ret+com;
        if(show!='' && ret==''){
            var ret = show;
        }
        return ret;
    }
}

function inputThousandsSeparator(x, y=0) {
    //remove commas
    if(x==null || x=='' || x==undefined){
        return '';
    }
    var koma = x.split('.');

    retVal = x ? parseFloat(koma[0].replace(/,/g, '')) : 0;
    //apply formatting
    var ret =  retVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if(ret=='NaN'){
        return '';
    }else{
        if(koma.length > 1 && y > 0){
            if(koma[1].length > 2){
                var a = parseFloat('0.'+koma[1]).toFixed(y);
                var b = a.split('.');
                var com = '.' + b[1];
            }else{
                var com = '.' + koma[1];
            }
        }else{
            var com = '';
        }
        return ret+com;
    }
}

function tanggalIndo(tgl=''){
    if(tgl!='' && tgl!=null && tgl!=undefined){
        var t = tgl.toString().split("-");
        var indo = t[2]+'/'+t[1]+'/'+t[0];
    }else{
        var indo = '';
    }
    return indo;
}

function dateIndo(tgl=''){
    if(tgl!='' && tgl!=null && tgl!=undefined){
        var t = tgl.toString().split("-");
        var indo = t[2]+'-'+t[1]+'-'+t[0];
    }else{
        var indo = '';
    }
    return indo;
}

function tanggalIndoName(tgl=''){
    if(tgl!='' && tgl!=null && tgl!=undefined){
        var t = tgl.toString().split("-");
       

        var BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        var indo = t[2]+'-'+BulanIndo[t[1]]+'-'+t[0];
    }else{
        var indo = '';
    }
    return indo;
}





jQuery(document).ready(function() {
    
    //GetInboxInvoice();
    // GetInboxPajak(); 
    // GetInboxReimburse();
    // GetInboxTransaksi();

    // $(document).idle({
    //     onIdle: function(){
    //         window.location=logout_url;                
    //     },
    //     idle: 900000
    //     //15 menit
    // });

});
