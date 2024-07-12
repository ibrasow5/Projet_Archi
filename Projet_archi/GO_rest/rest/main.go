package main

import (
	"net/http"
	"rest/rest/database"
	"rest/rest/routes"
	"github.com/gorilla/mux"
)

func main() {
    router := mux.NewRouter()
    database.Connect()
    routes.RegisterRoutes(router)
    http.ListenAndServe(":8080", router)
}

