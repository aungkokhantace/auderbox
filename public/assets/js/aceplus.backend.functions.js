/**
 * Created by Wai Yan Aung on 7/20/2016.
 */



function addNotification(title, text){
    $.gritter.add({
        title: title,
        text: text,
        time: 3000
    });
    return false;
};