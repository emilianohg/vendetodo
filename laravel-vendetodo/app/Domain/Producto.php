<?php


class Producto {
    private $nombre;
    private $descripcion;
    private $precio;
    private $marca_id;
    private $largo;
    private $ancho;
    private $alto;
    private $foto;

    public function __construct(
        $nombre, 
        $descripcion,
        $precio, 
        $marca_id,
        $largo,
        $ancho,
        $alto,
        $foto)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->marca_id = $marca_id;
        $this->largo = $largo;
        $this->ancho = $ancho;
        $this->alto = $alto;
        $this->foto = $foto;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getMarcaId()
    {
        return $this->marca_id;
    }

    public function getLargo()
    {
        return $this->largo;
    }

    public function getAncho()
    {
        return $this->ancho;
    }

    public function getAlto()
    {
        return $this->alto;
    }

    public function getFoto()
    {
        return $this->foto;
    }
    
}