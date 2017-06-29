export default class Participa {
  constructor () {
    this.apiURL = '/api/';
    this.token = document.head.querySelector('meta[name="jwt-token"]').content;
  }

  getBallot () {
    return this._call('get', 'ballot');
  }

  precheck (data) {
    return this._call('post', 'precheck', data);
  }

  requestSMS(data) {
    return this._call('post', 'request_sms', data);
  }

  castBallot(data) {
    return this._call('post', 'cast_ballot', data);
  }

  _call(type, url, data) {
    console.log(this.token);
    return new Promise((resolve, reject) => {
        axios[type](this.apiURL + url + '?token=' + this.token, data)
          .then(response => {
            resolve(response.data);
          })
          .catch(error => {
            reject(error.response.data);
          });
      });
  }
}
