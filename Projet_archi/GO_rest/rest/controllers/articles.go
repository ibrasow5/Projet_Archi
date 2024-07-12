package controllers

import (
	"rest/rest/database"
	"encoding/json"
	"net/http"
	"rest/rest/models"
	"github.com/gorilla/mux"
    "log"
)

func GetArticles(w http.ResponseWriter, r *http.Request) {
    var article []models.Article
    database.DB.Find(&article)
    json.NewEncoder(w).Encode(article)
}

func GetArticlesByCategory(w http.ResponseWriter, r *http.Request) {
    params := mux.Vars(r)
    var articles []models.Article
    categoryID := params["id"]

    result := database.DB.Where("categorie = ?", categoryID).Find(&articles)
    if result.Error != nil {
        log.Println("Error fetching articles by category:", result.Error)
        http.Error(w, result.Error.Error(), http.StatusInternalServerError)
        return
    }

    json.NewEncoder(w).Encode(articles)
}
