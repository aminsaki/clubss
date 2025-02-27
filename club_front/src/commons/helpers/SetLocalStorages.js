


export const setCart = (state, payload)=>{
    state.listCard.push({'id': payload.id, 'title': payload.title, 'price': payload.price});
    state.total = (state.total === 0) ? parseInt(payload.price) : parseInt(localStorage.getItem('total')) + parseInt(payload.price);
    localStorage.setItem("basketCart", JSON.stringify(state?.listCard));
    localStorage.setItem('total', state.total)
}