package controllers

import (
	"rest/rest/database"
	"encoding/json"
	"net/http"
	"rest/rest/models"
)

func GetCategorie(w http.ResponseWriter, r *http.Request) {
    var categorie []models.Category
    database.DB.Find(&categorie)
    json.NewEncoder(w).Encode(categorie)
}

