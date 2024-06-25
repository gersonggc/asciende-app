import axios from "axios"

class Request {
  isLoading = false;

  constructor(url, method, data , successCallback, failCallback, alwaysCallback = () => {}){
    this.url = url,
    this.method = method
    this.data = data
    this.successCallback = successCallback
    this.failCallback = failCallback
    this.alwaysCallback = alwaysCallback
    this.isLoading = false
  }

  get isLoading() {
    return this._isLoading
  }

  set isLoading(value) {
    this._isLoading = value;
  }

  execute = async function(params) {
    this.isLoading = true;
    axios({
      method: this.method,
      url: this.url,
      data: this.data
    })
    .then((response) => {
      this.isLoading = false;
      this.successCallback(response);
    })
    .catch((error) => {
      this.isLoading = false;
      this.failCallback(error);
    })
    .then((response) => {
      this.alwaysCallback(response);
      this.isLoading = false;
    });
  }
  
}

export default Request;