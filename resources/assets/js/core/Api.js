
class ApiClient {

    constructor (options) {
        //
    }

    install (Vue) {
        Vue.$api = this
        Vue.prototype.$api = this
    }

    /**
     *
     * @param key
     * @param params URL Parameter
     * @param queryParams
     * @returns {*}
     */
    getRoute (key, params = {}, queryParams = {}) {
        return axios.get(this.translateRoute(key, params), queryParams);
    }

    /**
     *
     * @param key
     * @param params URL Parameter
     * @param formData
     * @returns {*|AxiosPromise<any>|PromiseLike<HttpResponse>}
     */
    postRoute (key, params = {}, formData = {}) {
        return axios.post(this.translateRoute(key, params), formData);
    }

    translateRoute (key, params) {
        if (params) {
            return route(key, params);
        } else {
            return route(key);
        }
    }
}

export default new ApiClient();
