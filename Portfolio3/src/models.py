from flask.ext.sqlalchemy import SQLAlchemy

db = SQLAlchemy()


class Item(db.Model):
    __tablename__ = 'item'
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(255))
    thumbnail_path = db.Column(db.String(255))
    file_path = db.Column(db.String(255))
    description = db.Column(db.String(1024))

    def __init__(self, title, file_path):
        self.title = title
        self.file_path = file_path
