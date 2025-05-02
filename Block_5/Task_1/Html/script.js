$('#myForm').on('submit', function(e){
    e.preventDefault();
    
    const inputValue = $('input[name="situationInput"]').val();
    
    let message =  ((inputValue.indexOf("1111111") != -1) || (inputValue.indexOf("0000000") != -1 )) ? "YES" : "NO";

    $('#result').text(message);  
});