//20190612 - Created clientsideUserFormValidation.js - Banele

// clientside form validation
function validation(){    
    var name = document.getElementById("firstname");
    var surname = document.getElementById("lastname");
    var id_num = document.getElementById("id_number");
    var dateOfBirth = document.getElementById("dob");
    var emailAddress = document.getElementById("email");
    var pssword = document.getElementById("password");
    var confirmPssword = document.getElementById("confirmPassword");
    var genderMale = document.getElementById("gender_male").checked;
    var genderFemale = document.getElementById("gender_female").checked;
    var chkActiveStatus = document.getElementById("active").checked;
    var chkInactiveStatus = document.getElementById("inactive").checked;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var numericExpression = /^[0-9]+$/;
    var alphaExp = /^[a-zA-Z]+$/;
    // removing spaces and checking if the field is empty
    if(!(name.value.trim() == "" || surname.value.trim() == "" || id_num.value.trim() == "" || dateOfBirth.value.trim() == "" || emailAddress.value.trim() == "" || pssword.value.trim() == "")){
        // validating if it is numbers or not
        if(id_num.value.match(numericExpression)){
                //checking for all letters
            if(name.value.match(alphaExp) || surname.value.match(alphaExp)){
                //checking length of the ID
                if(id_num.value.length == 13){
                    //checking if there is a selection made on the radio buttons
                    if(genderMale || genderFemale){
                        if(chkActiveStatus ||  chkInactiveStatus){
                            if(pssword.value === confirmPssword.value){
                                if(pssword.value.length >= 4){
                                    if(emailAddress.value.match(mailformat)){
                                        return true;
                                    }
                                    alert("Incorrect email address format");
                                    return false;
                                }else{
                                    alert("Minimum password lenght is 4");
                                    return false;
                                }
                            }else{
                                alert("Password does not match!!");
                                return false;
                            }
                        }else{
                            alert("User status can either be active or inactive");
                            return false;
                        }
                    }else{
                        alert("Gender field must be selected");
                        return false;
                    }
                }else{
                    alert("13 Digits required");
                    return false;
                }
            }else{
                alert("Field must only be letters!");
                return false;
            }
        }else{
            alert("Field expect numbers only!");
            return false;
        }
    }else{
        alert("Field cannot be left empty!");
        return false;
    }    
}