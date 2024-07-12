package models

// import "gorm.io/gorm"

type Article struct {
    ID               int    `gorm:"primaryKey"`
    Titre            string `gorm:"column:titre"`
    Contenu          string `gorm:"column:contenu"`
    DateCreation     string `gorm:"column:dateCreation"`
    DateModification string `gorm:"column:dateModification"`
    CategorieID      int    `gorm:"column:categorie"`
}

func (Article) TableName() string {
    return "article"
}
