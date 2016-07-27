from BaseHTTPServer import BaseHTTPRequestHandler
import urlparse, json
from bs4 import BeautifulSoup
from urllib2 import urlopen
import sys

BASE_SPOJ_URL = "https://www.spoj.com/users/"


def q_solved(user_name):
    html = urlopen(BASE_SPOJ_URL + user_name).read()
    soup = BeautifulSoup(html, "lxml")
    table = soup.find("table",{"class":"table-condensed"})
    ques = table.find_all('a')
    for i in range(len(ques)):
        ques[i] = ques[i].string
    ques = filter(None, ques)
    return ques

def query_handler(queries):
    if 'user' in queries:
        user_name = queries['user'][0]
        isSolved = q_solved(user_name)
        message = isSolved
    else:
        message = "Home Page"
        print json.dumps(message)
    return json.dumps(message)

class GetHandler(BaseHTTPRequestHandler):

    def do_GET(self):
        parsed_path = urlparse.urlparse(self.path)
        queries = parsed_path.query
        print queries
        queries = urlparse.parse_qs(queries)
        message = query_handler(queries)
        self.send_response(200)
        self.end_headers()
        self.wfile.write(message)
        return

    def do_POST(self):
        
        content_len = int(self.headers.getheader('content-length'))
        post_body = self.rfile.read(content_len)
        self.send_response(200)
        self.end_headers()

        data = json.loads(post_body)

        self.wfile.write(data['foo'])
        return

if __name__ == '__main__':
    from BaseHTTPServer import HTTPServer
    server = HTTPServer(('localhost', 8080), GetHandler)
    print 'Starting server at http://localhost:8080'
    server.serve_forever()
