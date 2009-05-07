
function createStatusPicker(id,list,edid){
    var cnt = list.length;

    var picker = document.createElement('div');
    picker.className = 'picker';
    picker.id = id;
    picker.style.position = 'absolute';
    picker.style.display  = 'none';

    for(var key in list){
        if (!list.hasOwnProperty(key)) continue;

        var btn = document.createElement('button');
        btn.className = 'pickerbutton';

        var txt = document.createTextNode(list[key]);
        txt.innerHTML += '<br />';
        btn.title     = list[key];
        btn.style.display = 'block';

        btn.appendChild(txt);
        eval("btn.onclick = function(){statusPickerInsert('"+id+"','"+
                              jsEscape(list[key])+"','"+
                              jsEscape(edid)+"');return false;}");
        picker.appendChild(btn);
    }
    var body = document.getElementsByTagName('body')[0];
    body.appendChild(picker);
}

function addBtnActionTextlist(btn, props, edid, id)
{
    createStatusPicker('picker'+id,
         props['status'],
         edid);
    eval("btn.onclick = function(){showPicker('picker"+id+
                                    "',this);return false;}");
    return true;
}

function statusPickerInsert(pickerid,text,edid){
    // insert
    var txt = document.getElementById(edid);
    var now = new Date(); 
    var stext = "<status " + text + ">\nUser: "+jsEscape(USER)+
        "\nDate: " + ((now.getDate() < 10)?'0':'')  + now.getDate() + 
        "/" + ((now.getMonth()+1 < 10)?'0':'')  + (now.getMonth()+1) + 
        "/" + ((now.getYear()<999)?now.getYear()+1900:now.getYear()) +
        "\n</status>";
    
    var textreg = /<status [a-z0-9]+>[^<]*<\/status>/gi;
    if ( txt.value.match( textreg )) {
        txt.value = txt.value.replace( textreg , stext );
    } else {
        insertAtCarret(edid,stext);
    }
    

    // insert summary
    
    var esu = document.getElementById("edit__summary");
    var sumreg = /Status: [a-z0-9]+/gi;
    if ( esu.value.match(sumreg) ) {
        esu.value = esu.value.replace(sumreg,"Status: " + text);
    } else {
        esu.value += "Status: "+text;
    }

    // close picker
    pobj = document.getElementById(pickerid);
    pobj.style.display = 'none';
}


