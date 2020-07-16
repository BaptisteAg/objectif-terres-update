let VueProxied = null;

let uses = [];
let lazyInstances = [];

window.Vue = function (options) {
    this.options = options;
    this.lazyInstance = null;

    lazyInstances.push(this);
};
window.Vue.prototype.setInstance = function (instance) {
    this.lazyInstance = instance;
};
window.Vue.use = function (plugin) {
    console.log(plugin)
    uses.push(plugin);
};


(async _ => {
    VueProxied = await import(/* webpackChunkName: "vue" */'vue/dist/vue.common');


    lazyInstances.forEach(lazyInstance => {
        console.log(lazyInstance)
        lazyInstance.setInstance(new VueProxied(lazyInstance.options));
    });

    uses.forEach(plugin => VueProxied.use(plugin));

    window.Vue = VueProxied;

})();