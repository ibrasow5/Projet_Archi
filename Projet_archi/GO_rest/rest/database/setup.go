package database

import (
    "gorm.io/driver/mysql"
    "gorm.io/gorm"
    // "rest/rest/models"
)

var DB *gorm.DB

func Connect() {
    dsn := "papis:passer@tcp(127.0.0.1:3306)/mglsi?charset=utf8mb4&parseTime=True&loc=Local"
    var err error
    DB, err = gorm.Open(mysql.Open(dsn), &gorm.Config{})
    if err != nil {
        panic("failed to connect database")
    }

    // Synchronize the models with the existing tables without recreating them
   // DB.AutoMigrate(&models.Article{}, &models.Category{}, &models.User{})
}
