package routes

import (
    "github.com/gorilla/mux"
    "rest/rest/controllers"
)

func RegisterRoutes(router *mux.Router) {
    router.HandleFunc("/articles", controllers.GetArticles).Methods("GET")   
    router.HandleFunc("/articles/category/{id}", controllers.GetArticlesByCategory).Methods("GET")
    router.HandleFunc("/category", controllers.GetCategorie).Methods("GET")
    router.HandleFunc("/users/{id}", controllers.GetUserByID).Methods("GET")
    router.HandleFunc("/users", controllers.GetUsers).Methods("GET")
}

