#!/bin/bash

# Définir le nom du projet
PROJECT_NAME="rest"

# Créer les répertoires
mkdir -p $PROJECT_NAME/{controllers,models,routes,database}

# Créer les fichiers
touch $PROJECT_NAME/main.go
touch $PROJECT_NAME/controllers/articles.go
touch $PROJECT_NAME/controllers/categories.go
touch $PROJECT_NAME/controllers/users.go
touch $PROJECT_NAME/models/article.go
touch $PROJECT_NAME/models/category.go
touch $PROJECT_NAME/models/user.go
touch $PROJECT_NAME/routes/routes.go
touch $PROJECT_NAME/database/setup.go

# Ajouter du contenu de base aux fichiers
echo 'package main

import (
    "net/http"
    "github.com/gorilla/mux"
    "rest/routes"
    "rest/database"
)

func main() {
    router := mux.NewRouter()
    database.Connect()
    routes.RegisterRoutes(router)
    http.ListenAndServe(":8080", router)
}
' > $PROJECT_NAME/main.go

echo 'package controllers

import (
    "encoding/json"
    "net/http"
    "github.com/gorilla/mux"
    "rest/database"
    "rest/models"
)

func GetArticles(w http.ResponseWriter, r *http.Request) {
    var articles []models.Article
    database.DB.Find(&articles)
    json.NewEncoder(w).Encode(articles)
}

func GetArticlesByCategory(w http.ResponseWriter, r *http.Request) {
    vars := mux.Vars(r)
    category := vars["category"]
    var articles []models.Article
    database.DB.Where("categorie = ?", category).Find(&articles)
    json.NewEncoder(w).Encode(articles)
}
' > $PROJECT_NAME/controllers/articles.go

echo 'package controllers

import (
    "encoding/json"
    "net/http"
    "rest/database"
    "rest/models"
)

func GetCategories(w http.ResponseWriter, r *http.Request) {
    var categories []models.Category
    database.DB.Find(&categories)
    json.NewEncoder(w).Encode(categories)
}
' > $PROJECT_NAME/controllers/categories.go

echo 'package controllers

import (
    "encoding/json"
    "net/http"
    "rest/database"
    "rest/models"
)

func GetUsers(w http.ResponseWriter, r *http.Request) {
    var users []models.User
    database.DB.Find(&users)
    json.NewEncoder(w).Encode(users)
}
' > $PROJECT_NAME/controllers/users.go

echo 'package models

import "gorm.io/gorm"

type Article struct {
    gorm.Model
    Titre            string `json:"titre"`
    Contenu          string `json:"contenu"`
    DateCreation     string `json:"dateCreation"`
    DateModification string `json:"dateModification"`
    CategorieID      int    `json:"categorie"`
}
' > $PROJECT_NAME/models/article.go

echo 'package models

import "gorm.io/gorm"

type Category struct {
    gorm.Model
    Libelle string `json:"libelle"`
}
' > $PROJECT_NAME/models/category.go

echo 'package models

import "gorm.io/gorm"

type User struct {
    gorm.Model
    Username   string `json:"username"`
    MotDePasse string `json:"mot_de_passe"`
    Role       string `json:"role"`
}
' > $PROJECT_NAME/models/user.go

echo 'package routes

import (
    "github.com/gorilla/mux"
    "rest/controllers"
)

func RegisterRoutes(router *mux.Router) {
    router.HandleFunc("/articles", controllers.GetArticles).Methods("GET")
    router.HandleFunc("/articles/{category}", controllers.GetArticlesByCategory).Methods("GET")
    router.HandleFunc("/categories", controllers.GetCategories).Methods("GET")
    router.HandleFunc("/users", controllers.GetUsers).Methods("GET")
}
' > $PROJECT_NAME/routes/routes.go

echo 'package database

import (
    "gorm.io/driver/mysql"
    "gorm.io/gorm"
    "rest/models"
)

var DB *gorm.DB

func Connect() {
    dsn := "username:password@tcp(127.0.0.1:3306)/dbname?charset=utf8mb4&parseTime=True&loc=Local"
    var err error
    DB, err = gorm.Open(mysql.Open(dsn), &gorm.Config{})
    if err != nil {
        panic("failed to connect database")
    }

    DB.AutoMigrate(&models.Article{}, &models.Category{}, &models.User{})
}
' > $PROJECT_NAME/database/setup.go
