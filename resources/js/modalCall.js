import Swal from "sweetalert2";

const callModalOnClick = (element) => {
  element.addEventListener('click', function(event) {
    event.preventDefault();
    const {currentTarget} = event;
    console.log(currentTarget)
    Swal.fire({
        title: "Confirmación",
        text: "¿Está seguro que desea realizar esta acción?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00A3AC",
        cancelButtonColor: "#4A494A",
        confirmButtonText: "¡Sí!",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {
          location.href=`${currentTarget.href}`
        }
      })
  })
}

const callModalOnClickWithField = (element) => {
    element.addEventListener('click', function(event) {
      event.preventDefault();
      const {currentTarget} = event;
      Swal.fire({
        title: "Confirmación",
        text: "¿Está seguro que desea realizar esta acción?",
        icon: "warning",
        html: `
          <div class="card">
            <div class="card-body row">
              <div class="form-group col-sm-12">
                <label for="reversal_reason">Causa de Reversión</label>
                <div class="input-group mb-3" bis_skin_checked="1">
                  <textarea id="reversal_reason" name="reversal_reason" class="form-control" rows="3" required minlength="10"></textarea>
                </div>
              </div>
            </div>
          </div>
        `,
        showCancelButton: true,
        confirmButtonColor: "#00A3AC",
        cancelButtonColor: "#4A494A",
        confirmButtonText: "¡Sí!",
        cancelButtonText: "No",
        preConfirm: () => {
          const reversalReason = document.getElementById('reversal_reason').value;
          if (reversalReason.length < 10) {
            Swal.showValidationMessage('La causa de reversión debe tener al menos 10 caracteres');
          }
          return { reversalReason: reversalReason };
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const reversalReason = result.value.reversalReason;
          location.href = `${currentTarget.href}?reversal_reason=${reversalReason}`;
        }
      });
    });
}

const modalCall = () => {
  const linksToCallModal = document.querySelectorAll('.toggleModal');

  if( linksToCallModal.length > 0 )
  {
      linksToCallModal.forEach(callModalOnClick)
  }

  const linksToCallModalWithField = document.querySelectorAll('.toggleModalWithField');

  if( linksToCallModalWithField.length > 0 )
  {
      linksToCallModalWithField.forEach(callModalOnClickWithField)
  }

}

export {modalCall}
