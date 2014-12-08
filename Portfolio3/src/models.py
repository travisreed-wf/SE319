from flask.ext.sqlalchemy import SQLAlchemy

db = SQLAlchemy()


class Item(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(255))
    thumbnail_id = db.Column(db.Integer, db.ForeignKey('thumbnail.id'))
    description = db.Column(db.String(1024))
    extension = db.Column(db.String(15))

    def __init__(self, title, filename, thumbnail_id):
        self.title = title
        self.thumbnail_id = thumbnail_id
        if "." in filename:
            self.extension = filename.split('.')[1]

    def get_filename(self):
        if self.extension:
            return str(self.id) + "." + self.extension
        else:
            return str(self.id)


class Thumbnail(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    extension = db.Column(db.String(15))
    items = db.relationship('Item', backref='item',
                            lazy='dynamic')

    def __init__(self, filename):
        if "." in filename:
            self.extension = filename.split('.')[-1]

    def get_filename(self):
        if self.extension:
            return str(self.id) + "." + self.extension
        else:
            return str(self.id)