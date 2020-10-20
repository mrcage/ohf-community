const permissions = window.Laravel.permissions

export function can(key) {
    return permissions[key] != undefined ? permissions[key] : false
}

const cfg = window.Laravel.config
export function config(key) {
    return cfg[key] != undefined ? cfg[key] : null
}
