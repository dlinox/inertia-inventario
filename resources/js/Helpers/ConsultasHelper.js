const getBienKByCodigo = async (codigo) => {
    let res = await axios.get("/inventario/search-codigos/" + codigo);
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
}
