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
        return render_template('home.html')
