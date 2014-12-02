from flask.ext.sqlalchemy import SQLAlchemy

db = SQLAlchemy()


class Item(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(255))
    thumbnail_id = db.Column(db.Integer, db.ForeignKey('thumbnail.id'))
    description = db.Column(db.String(1024))

    def __init__(self, title):
        self.title = title


class Thumbnail(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    items = db.relationship('Item', backref='item',
                                lazy='dynamic')