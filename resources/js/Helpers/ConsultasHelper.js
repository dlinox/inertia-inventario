const getBienKByCodigo = async (codigo) => {
    let res = await axios.get("/inventario/search-codigos/" + codigo);
    return res.data.datos;
};

const getBienByCodigo = async (data) => {
    let res = await axios.post("/inventario/get-bien-by-codigo", data);
    return res.data.datos;
};




const getBienKById = async (id) => {
    let res = await axios.get("/inventario/get-bien-by-id/" + id);
    return res.data.datos;
};



const getPersonaById = async () => {
    let res = await axios.get("/inventario/search-personas-by-id/" + item.id_persona);
    return res.data.datos;
}

const getOficinaById = async () => {
    let res = await axios.get("/inventario/search-oficina-by-id/" + item.id_persona);
    return res.data.datos;
}

module.exports = {
    getBienKByCodigo,
    getPersonaById,
    getOficinaById,
    getBienKById,
    getBienByCodigo
}
