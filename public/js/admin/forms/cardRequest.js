if(crud.field){
  crud.field('birthdate').onChange(function(field) {
    if(!field.value) return;
    const birthdate = new Date(field.value)
    
    const month_diff = Date.now() - birthdate;  
    
    //convert the calculated difference in date format  
    var age_dt = new Date(month_diff);   
    
    //extract year from date      
    var year = age_dt.getUTCFullYear();  
    
    //now calculate the age of the user  
    const age = Math.abs(year - 1970);  
    
  const {input} = crud.field('age')

  input.value = age
}).change()

const [input] = document.getElementsByClassName('rifInputMask')
const showClientInput = document.querySelector("input[name='name']")

input.addEventListener('change', async function(event) {

  const {value} = event.target
  const badgeClass = new badgeInfo(event.target.parentElement)
  if(!showClientInput) return

  try{
    const response = await fetch('/admin/client/getClient', {
      headers:{
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      method:'POST',
      body: JSON.stringify({co_cli:value})
    })

    const result = await response.json()
    if(result.client){
      showClientInput.value = result.client.cli_des
      badgeClass.showBadge('success', 'Cliente existe en nuestra base de datos')
      return
    }
    badgeClass.showBadge('secondary', 'Cliente No existe en nuestra base de datos')
    showClientInput.value = ''
  }catch(error){
    console.error(error)
  }

})
}