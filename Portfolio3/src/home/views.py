import flask
from flask import flash
from flask import redirect
from flask import render_template
from flask import url_for
from flask.views import MethodView
import models
import re
import json


class HomeScreenView(MethodView):

    def get(self):
        l = []
        items = models.Item.query.all()
        for item in items:
            l.append((item, models.Thumbnail.query.filter_by(id=item.thumbnail_id).first()))
        return render_template('home.html', items_and_thumbs=l)
