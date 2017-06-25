export default class Participa {
  constructor () {
    this.apiURL = '';
  }

  getBallot () {
    return new Promise((resolve, reject) => {
      axios.get('/api/ballot')
        .then(response => {
          resolve(response.data);
        })
        .catch(error => {
          reject(error.response.data);
        });
    });
  }
}
