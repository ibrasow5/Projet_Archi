package models

// import "gorm.io/gorm"

type Category struct {
    ID      int    `gorm:"primaryKey"`
    Libelle string `gorm:"column:libelle"`
}

func (Category) TableName() string {
    return "categorie"
}
