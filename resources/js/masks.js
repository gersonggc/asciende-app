import { IMask } from 'vue-imask';

const moneyMask = {
  mask: "##.###,##$",
  reversed: true,
  tokens: {
    '#': { pattern: /[0-9]/ }
  }
}

const VesMask = {
  mask: "###.###.###,##Bs",
  reversed: true,
  tokens: {
    '#': { pattern: /[0-9]/ }
  }
}

const rifMask = {
  mask: "#-********-*",
  tokens: {
    '#': { pattern: /[JVGE]/,transform: (character) => character.toUpperCase() },
    '*': { pattern: /[0-9]/}
  }
}

const phoneMask = {
    mask: '####-000-0000',
    lazy:true,
    blocks: {
      '####': {
        mask: IMask.MaskedEnum,
        enum:['0412','0414','0424','0426','0416']
      }
    }
}

export { rifMask, phoneMask, moneyMask, VesMask }
