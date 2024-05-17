class badgeInfo {

  spanBadge = document.createElement('span')
  container = document.createElement(('div'))

  constructor(elemToAttach){
    this.elemToAttach = elemToAttach
    this.container.classList.add('badge-container')
  }

  clear(){
    this.container.innerHTML = ''
    const containersToClear = document.querySelector('.badge-container');
    if(containersToClear){
      containersToClear.remove();
    }
  }
  
  format(type, text){
    this.spanBadge.classList.add('badge')
    this.spanBadge.classList.add(`badge-${type}`)
    this.spanBadge.textContent = text
  }

  showBadge(type, text){
    this.clear();
    this.format(type, text);
    this.elemToAttach.appendChild(this.container)
    this.container.appendChild(this.spanBadge)
  }
}