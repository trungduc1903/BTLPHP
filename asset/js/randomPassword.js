function autoGeneratePassword(length=8){
    let randomstring = Math.random().toString(36).slice(-length);
    return randomstring;
}
