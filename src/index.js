 import "./index.scss";

(function(){
    document.addEventListener('DOMContentLoaded', function(){
            const form = document.querySelector('.casauto-preferences-wrapper form');
            const userId = document.querySelector('.casauto-preferences-wrapper').dataset.user;
            const formId = document.querySelector('.casauto-preferences-wrapper').dataset.formId;
            const nonce = document.querySelector('.casauto-preferences-wrapper').dataset.nonce;
            const meanContact = document.querySelector('.casauto-preferences-wrapper').dataset.contact;
            const vehicleType = document.querySelector('.casauto-preferences-wrapper').dataset.vehicleType;
           document.querySelector(`#wpforms-${formId}-field_4`).value = userId;
          //  const vehicleTypes = document.querySelector('.casauto-preferences-wrapper pre').textContent;
            console.log(meanContact);
            // if(vehicleTypes){

            //     const vehicleTypesData = JSON.parse(vehicleTypes);
              
    
            //     for(const option of document.querySelectorAll(`#wpforms-${formId}-field_2 option`)){
            //         const value = Number.parseInt(option.value);
                   
            //         if (vehicleTypesData.indexOf(value) !== -1) {
            //             option.setAttribute('selected', 'selected');
            //           }
            //           else {
            //             option.removeAttribute('selected');
            //           }
            //     }
            // }
            
           
           if(meanContact){

               document.querySelector(`#wpforms-${formId}-field_3`).value = meanContact;
           }
           if(vehicleType){
               document.querySelector(`#wpforms-${formId}-field_2`).value = vehicleType;
           }
            form.addEventListener('submit', async function(event){
                event.preventDefault();
                
                const data = new FormData(event.target);
                
                try {
                    const response  = await fetch(`/wp-json/submit-quotes/v1/quotes/?_wpnonce=${nonce}`, {
                                                method: 'POST',
                                                body: data,
                                                headers: {
                                                    
                                                    'X-WP-Nonce': nonce
                                                },
                                            });
                    const responseData = await response.json();
                    console.log(responseData);
                    
                } catch (error) {
                    console.log(error);
                }                
               
                
            })
            
    })
} )();