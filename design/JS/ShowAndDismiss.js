/**
 * Created by Ondřej on 25.06.2016.
 */
function ShowAndDimiss(ID){
    el=document.getElementById(ID).style;
    el.display=(el.display == 'block')?'none':'block';
}