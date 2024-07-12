package models

// import "gorm.io/gorm"

type User struct {
    ID       int    `gorm:"primaryKey"`
    Username string `gorm:"column:username"`
    Password string `gorm:"column:mot_de_passe"`
    Role     string `gorm:"column:role"`
}

func (User) TableName() string {
    return "utilisateurs"
}
