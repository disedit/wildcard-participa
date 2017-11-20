export default class Participa {
    constructor () {
        this.apiURL = '/api/';
    }

    getBallot() {
        return this._call('get', 'ballot');
    }

    getResults(force) {
        console.log(force);
        return this._call('get', 'results', { params: { force } });
    }

    getSidebar() {
        return this._call('get', 'sidebar');
    }

    precheck(data) {
        return this._call('post', 'precheck', data);
    }

    requestSMS(data) {
        return this._call('post', 'request_sms', data);
    }

    castBallot(data) {
        return this._call('post', 'cast_ballot', data);
    }

    anullBallot(data) {
        return this._call('post', 'anull_ballot', data);
    }

    lookUp(data) {
        return this._call('post', 'id_lookup', data);
    }

    _call(type, url, data) {
        return new Promise((resolve, reject) => {
            axios[type](this.apiURL + url, data).then(response => {
                resolve(response.data);
            }).catch(error => {
                if(error.response.status == 500) {
                    reject({
                        'error': ['Error del sistema. És possible que aquest error siga temporal. Refresca la pàgina i torna a intentar-ho o posa\'t en contacte.']
                    });
                } else if(error.response.data.hasOwnProperty('errors')){
                    reject(error.response.data.errors);
                } else {
                    reject(error.response.data);
                }
            });
        });
    }
}
