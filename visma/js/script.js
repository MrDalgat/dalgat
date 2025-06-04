function toggleReason(select,id){
    const reasonField = document.getElementById('reason_' + id);
    if(select.value === '3') {
        reasonField.style.display = 'block';

    }else{
        reasonField.style.display = 'none';
    }
}