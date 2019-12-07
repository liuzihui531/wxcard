var width = $("#container").attr("data-width");
width = width == undefined ? 800 : parseInt(width);
var ue = UE.getEditor('container',{
    initialFrameWidth: width,
    initialFrameHeight: 300
});