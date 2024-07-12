package controllers

import (
	"rest/rest/database"
	"encoding/json"
	"net/http"
    "github.com/gorilla/mux"
	"rest/rest/models"
    "log"
)

func GetUsers(w http.ResponseWriter, r *http.Request) {
    var utlisateurs []models.User
    database.DB.Find(&utlisateurs)
    json.NewEncoder(w).Encode(utlisateurs)
}

func GetUserByID(w http.ResponseWriter, r *http.Request) {
    params := mux.Vars(r)
    var utilisateurs models.User
    userID := params["id"]

    result := database.DB.First(&utilisateurs, userID)
    if result.Error != nil {
        log.Println("Error fetching utilisateurs by ID:", result.Error)
        http.Error(w, result.Error.Error(), http.StatusInternalServerError)
        return
    }

    json.NewEncoder(w).Encode(utilisateurs)
}