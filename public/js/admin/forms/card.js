

getClient()
addCompany()

function getClient(){
const [input] = document.getElementsByClassName('rifInputMask')
const [showClientInput] = document.getElementsByClassName('ShowClientName')

if(!input)return;

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

function addCompany(){
  if(!crud.field) return;
  console.log('BEta')
  crud.field('card_type').onChange(function(field){

    if(field.value === 'COMPANY') {
      crud.field('company_id').show().enable();
    } else {
      crud.field('company_id').hide().disable();
    }

  }).change();

}