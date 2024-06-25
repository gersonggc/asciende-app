/* mask input con numeros */
import IMask from 'imask';
import { MaskInput } from "maska"

const rifMask = (input) => {
  IMask(input, {
    mask : '{#}-0000000000',
    prepare: function (str) {
      return str.toUpperCase();
    },
    definitions: {
      '#': /[JVEG]/
    }
  })
}

const phoneMask = (input) => {
  IMask(input, {
    mask: '####-000-0000',
    lazy:true,
    blocks: {
      '####': {
        mask: IMask.MaskedEnum,
        enum:['0412','0414','0424','0426','0416']
      }
    }
  })
}


const addAnchor = () => {
  const div = document.querySelector('.preview_image')
  let anchor = document.createElement("a");
  anchor.classList.add('remove-image');
  anchor.style.display = 'inline'
  anchor.text = 'x'
  div.appendChild(anchor)

  anchor.addEventListener('click', function(event) {
    const element = document.querySelector('.preview_image_src')
    const imageInput = document.querySelector('.imageFile')
    const label = document.querySelector('.backstrap-file-label')
    if(element){
      element.src = ''
      imageInput.value = ''
      label.firstChild.remove()
      anchor.remove()
    }
  })
}

const renderImage = (event) => {
  const [file] = event.target.files
  const element = document.querySelector('.preview_image_src')
  if(file){
    element.src = URL.createObjectURL(file)
    addAnchor()
  }
}

const addPreviewImageFile = (element) => {
  const { preview = null } = element.dataset
  if(!preview) return;
  let div = document.createElement("div")
  div.classList.add('preview_image')
  element.parentElement.appendChild(div)

  let img = document.createElement("img")
  img.classList.add('preview_image_src')
  div.appendChild(img)
}

const addMask = () => {
  const elements = document.getElementsByClassName('rifInputMask');
  if(elements.length === 0) return;
  elements.forEach(rifMask)
}

const addPhoneMask = () => {
  const phoneElements = document.getElementsByClassName('phoneNumber')
  if(phoneElements.length === 0) return;
  phoneElements.forEach(phoneMask)
}

const addMoneyMask = () => {
  // const moneyElements = document.getElementsByClassName('moneyNumber')

  new MaskInput('input.moneyNumber', {
    mask: "###.###,##",
    reversed: true,
  })

  new MaskInput('input.moneyCalculatorUsd', {
    mask: "##.###.###,## $",
    reversed: true,
  })

  new MaskInput('input.moneyCalculatorBs', {
    mask: "#.###.###,## Bs",
    reversed: true,
  })

  new MaskInput('input.moneyPercentaje', {
    mask: "#.###.###,## %",
    reversed: true,
  })
}

/* Vista de imagen al cargar un dato tipo field */
const imagePreview = () => {
  const elements = document.getElementsByClassName('imageFile')
  if(elements.length === 0) return;
  elements.forEach((element) => {
    addPreviewImageFile(element)
    element.addEventListener('change', renderImage)
  })

  const [existingElementsFile] = document.getElementsByClassName('existing-file');

  if(!existingElementsFile){
    return;
  }
  const childElement = existingElementsFile.querySelector('a');

  let div = document.createElement("div")
  div.classList.add('preview_image')
  existingElementsFile.appendChild(div)

  let img = document.createElement("img")
  img.src = childElement.href
  img.classList.add('preview_image_src')
  div.appendChild(img)

  const [clearButton] = document.getElementsByClassName('file_clear_button')

  /* Recreate new input file */
  clearButton.addEventListener('click', function(event){
    existingElementsFile.remove()
    const [inputFile] = document.getElementsByClassName('imageFile')
    inputFile.addEventListener('change', renderImage)
  })
}


const prepareAmmount = (input) => {

    if (isFinite(input)) return input;
    const cleanMask = input.replace(/\$/g, "");

    if (cleanMask.includes(",")) {
        const claenPoints = cleanMask.replace(/\./g, "");

        return claenPoints.replace(",", ".")
    }

    return cleanMask;
}


const attachToAnchor = (event) => {
  event.preventDefault();
  navigator.clipboard.writeText(event.target.dataset.clipboard);
}

const clipboardCards = () => {
  const linkToCopy = document.querySelectorAll('.clipboard_card');

  linkToCopy.forEach((element) => {
    element.addEventListener('click', attachToAnchor)
  })
}

export {addMask, imagePreview, addPhoneMask, addMoneyMask, prepareAmmount, clipboardCards };
