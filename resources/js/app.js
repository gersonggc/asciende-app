import './bootstrap';
import { addMask, imagePreview, addPhoneMask, addMoneyMask, clipboardCards } from './helpers';
import { modalCall } from './modalCall';

/* añade todos los scripts necesarios al cargar el objeto window */
window.addEventListener("load", (event) => {
  addMask();
  addPhoneMask();
  imagePreview();
  modalCall();
  addMoneyMask();
  clipboardCards();
})

